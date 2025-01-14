<?php

declare(strict_types=1);

require_once __DIR__ . '/RequestParam.php';
require_once __DIR__ . '/Log.php';

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

		$this->checkDependencies();
		$this->validateInstallPath();
		$this->cloneRepository();
		$this->configEnvironmentVariables();
		$this->installComposerDependencies();
		$this->installNodeDependencies();
		$this->startDockerContainers();
		$this->generateAppKey();
		$this->runMigrations($this->installationData[RequestParam::RUN_SEEDERS->value] === 1);
		$this->storageLink();

		$this->logger->write("Containers started successfully.", 100);
	}

	protected function validateInstallPath(): void
	{
		if (empty($this->installPath)) {
			throw new InvalidArgumentException('Installation path cannot be empty.');
		}

		if (!is_writable(dirname($this->installPath))) {
			throw new RuntimeException("Cannot write to the specified directory: " . dirname($this->installPath));
		}
	}

	protected function checkDependencies(): void
	{
		$gitVersion = shell_exec('git --version');

		if (is_bool($gitVersion) && empty($gitVersion)) {
			throw new RuntimeException('Git is not installed or not available in PATH.');
		}

		$dockerVersion = shell_exec('docker -v');

		if (is_bool($dockerVersion) && empty($dockerVersion)) {
			throw new RuntimeException('Docker is not installed or not available in PATH.');
		}

		$this->logger->write("Dependencies checked: Git and Docker are available.", 10);
	}

	protected function cloneRepository(): void
	{
		mkdir($this->installPath, 0755, true);

		$cloneResult = shell_exec("cd {$this->installPath} && git clone {$this->repositoryUrl} .");

		if (is_bool($cloneResult) && empty($cloneResult)) {
			throw new RuntimeException('Failed to clone repository.');
		}

		$this->logger->write("Repository cloned successfully.", 25);
	}

	protected function configEnvironmentVariables(): void
	{
		// Backend
		$this->backendEnvHelper->set('APP_NAME', $this->installationData[RequestParam::APP_NAME->value]);
		$this->backendEnvHelper->set('DB_DATABASE', $this->installationData[RequestParam::DB_NAME->value]);
		$this->backendEnvHelper->set('DB_USERNAME', $this->installationData[RequestParam::DB_USER->value]);
		$this->backendEnvHelper->set('DB_PASSWORD', $this->installationData[RequestParam::DB_PASSWORD->value]);

		// Frontend
		$this->frontendEnvHelper->set('APP_NAME', $this->installationData[RequestParam::APP_NAME->value]);

		$this->logger->write("Environment variables configured successfully.", 30);
	}

	protected function installComposerDependencies(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts");

		$this->logger->write("Composer dependencies installed.", 45);
	}

	protected function installNodeDependencies(): void
	{
		shell_exec("cd {$this->installPath}/frontend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html node:22-alpine npm install --force");

		$this->logger->write("Node.js dependencies installed.", 60);
	}

	protected function startDockerContainers(): void
	{
		shell_exec("cd {$this->installPath} && docker compose -f backend/docker-compose.yml up -d && docker compose -f frontend/docker-compose.yml up -d");

		$this->logger->write("Docker containers started.", 75);
	}

	protected function generateAppKey(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan key:generate");

		$this->logger->write("App key generated.", 80);
	}

	protected function runMigrations(bool $withSeeders = false): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan migrate --force");

		if ($withSeeders) {
			shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan db:seed");
		}

		$this->logger->write("Migrations run.", 90);
	}

	protected function storageLink(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan storage:link");

		$this->logger->write("Storage linked.", 95);
	}
}
