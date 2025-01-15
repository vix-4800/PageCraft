<?php

declare(strict_types=1);

namespace PageCraft;

require_once __DIR__ . './../../autoloader.php';

use PageCraft\Exceptions\InstallationException;

class Installer
{
	protected string $repositoryUrl = 'https://github.com/vix-4800/PageCraft.git';

	protected string $installPath;

	protected Log $logger;

	protected Env $backendEnvHelper;

	protected Env $frontendEnvHelper;

	public function __construct(
		protected array $installationData
	) {
		$this->installPath = $this->installationData[RequestParam::INSTALL_PATH->value] . '/pagecraft';

		$this->logger = new Log();
		$this->logger->clear();

		$this->backendEnvHelper = new Env("{$this->installPath}/backend");
		$this->frontendEnvHelper = new Env("{$this->installPath}/frontend");
	}

	public function install(): void
	{
		$this->logger->write("Starting installation process...", 0);

		$this->checkDependencies()
			->validateInstallPath()
			->cloneRepository()
			->configEnvironmentVariables()
			->installComposerDependencies()
			->installNodeDependencies()
			->startDockerContainers()
			->generateAppKey()
			->runMigrations($this->installationData[RequestParam::RUN_SEEDERS->value] === 1)
			->storageLink();

		$this->logger->write("Containers started successfully.", 100);
	}

	protected function validateInstallPath(): self
	{
		if (empty($this->installPath)) {
			throw new InstallationException('Installation path cannot be empty.');
		}

		if (!is_writable(dirname($this->installPath))) {
			throw new InstallationException("Cannot write to the specified directory: " . dirname($this->installPath));
		}

		return $this;
	}

	protected function checkDependencies(): self
	{
		$gitVersion = shell_exec('git --version');

		if (is_bool($gitVersion) && empty($gitVersion)) {
			throw new InstallationException('Git is not installed or not available in PATH.');
		}

		$dockerVersion = shell_exec('docker -v');

		if (is_bool($dockerVersion) && empty($dockerVersion)) {
			throw new InstallationException('Docker is not installed or not available in PATH.');
		}

		$this->logger->write("Dependencies checked: Git and Docker are available.", 10);

		return $this;
	}

	protected function cloneRepository(): self
	{
		mkdir($this->installPath, 0755, true);

		$cloneResult = exec("cd {$this->installPath} && git clone {$this->repositoryUrl} .");

		if (is_bool($cloneResult) && empty($cloneResult)) {
			throw new InstallationException('Failed to clone repository.');
		}

		$this->logger->write("Repository cloned successfully.", 25);

		return $this;
	}

	protected function configEnvironmentVariables(): self
	{
		$appName = $this->installationData[RequestParam::APP_NAME->value];
		$appEnv = $this->installationData[RequestParam::APP_ENVIRONMENT->value];
		$appUrl = $this->installationData[RequestParam::APP_URL->value];
		$backendPort = $this->installationData[RequestParam::BACKEND_PORT->value];

		$databaseName = $this->installationData[RequestParam::DB_NAME->value];
		$databaseUser = $this->installationData[RequestParam::DB_USER->value];
		$databasePassword = $this->installationData[RequestParam::DB_PASSWORD->value];

		// Backend
		$this->backendEnvHelper->createFromExample();
		$this->backendEnvHelper->set('APP_NAME', $appName);
		$this->backendEnvHelper->set('APP_ENV', $appEnv);
		$this->backendEnvHelper->set('APP_PORT', $backendPort);
		$this->backendEnvHelper->set('APP_URL', "{$appUrl}:\${APP_PORT}");
		$this->backendEnvHelper->set('FRONTEND_URL', $appUrl);
		$this->backendEnvHelper->set('APP_LOCALE', $this->installationData[RequestParam::APP_LOCALE->value]);
		$this->backendEnvHelper->set('APP_TIMEZONE', $this->installationData[RequestParam::APP_TIMEZONE->value]);

		$this->backendEnvHelper->set('DB_DATABASE', $databaseName);
		$this->backendEnvHelper->set('DB_USERNAME', $databaseUser);
		$this->backendEnvHelper->set('DB_PASSWORD', $databasePassword);

		$this->backendEnvHelper->set('MAIL_MAILER', $this->installationData[RequestParam::MAIL_DRIVER->value]);
		$this->backendEnvHelper->set('MAIL_HOST', $this->installationData[RequestParam::MAIL_HOST->value]);
		$this->backendEnvHelper->set('MAIL_PORT', $this->installationData[RequestParam::MAIL_PORT->value]);
		$this->backendEnvHelper->set('MAIL_USERNAME', $this->installationData[RequestParam::MAIL_USERNAME->value]);
		$this->backendEnvHelper->set('MAIL_PASSWORD', $this->installationData[RequestParam::MAIL_PASSWORD->value]);
		$this->backendEnvHelper->set('MAIL_ENCRYPTION', $this->installationData[RequestParam::MAIL_ENCRYPTION->value]);

		$nginxDockerConf = file_get_contents("{$this->installPath}/backend/docker/nginx/default.conf");
		$nginxDockerConf = str_replace('server_name localhost;', "server_name {$appUrl};", $nginxDockerConf);
		file_put_contents("{$this->installPath}/backend/docker/nginx/default.conf", $nginxDockerConf);

		$mySqlDockerConf = file_get_contents("{$this->installPath}/backend/docker/mysql/init.sql");
		$mySqlDockerConf = str_replace('IF NOT EXISTS pagecraft', "IF NOT EXISTS {$databaseName}", $mySqlDockerConf);
		$mySqlDockerConf = str_replace('CREATE USER \'pagecraft_user\'', "CREATE USER '{$databaseUser}'", $mySqlDockerConf);
		$mySqlDockerConf = str_replace('IDENTIFIED BY \'pagecraft\'', "IDENTIFIED BY '{$databasePassword}'", $mySqlDockerConf);
		$mySqlDockerConf = str_replace('ON pagecraft.* TO \'pagecraft_user\'', "ON {$databaseName}.* TO '{$databaseUser}'", $mySqlDockerConf);
		file_put_contents("{$this->installPath}/backend/docker/mysql/init.sql", $mySqlDockerConf);

		// Frontend
		$this->frontendEnvHelper->createFromExample();
		$this->frontendEnvHelper->set('APP_NAME', $appName);
		$this->frontendEnvHelper->set('APP_ENV', $appEnv);
		$this->frontendEnvHelper->set('APP_URL', $appUrl);
		$this->frontendEnvHelper->set('API_PORT', $backendPort);

		$this->logger->write("Environment variables configured successfully.", 30);

		return $this;
	}

	protected function installComposerDependencies(): self
	{
		shell_exec("cd {$this->installPath}/backend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts");

		$this->logger->write("Composer dependencies installed.", 45);

		return $this;
	}

	protected function installNodeDependencies(): self
	{
		shell_exec("cd {$this->installPath}/frontend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html node:22-alpine npm install --force");

		$this->logger->write("Node.js dependencies installed.", 60);

		return $this;
	}

	protected function startDockerContainers(): self
	{
		shell_exec("cd {$this->installPath} && docker compose -f backend/docker-compose.yml up -d && docker compose -f frontend/docker-compose.yml up -d");

		$this->logger->write("Docker containers started.", 75);

		return $this;
	}

	protected function generateAppKey(): self
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan key:generate");

		$this->logger->write("App key generated.", 80);

		return $this;
	}

	protected function runMigrations(bool $withSeeders = false): self
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan migrate --force");

		if ($withSeeders) {
			shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan db:seed");
		}

		$this->logger->write("Migrations run.", 90);

		return $this;
	}

	protected function storageLink(): self
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan storage:link");

		$this->logger->write("Storage linked.", 95);

		return $this;
	}
}
