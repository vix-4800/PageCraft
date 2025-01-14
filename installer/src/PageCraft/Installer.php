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

		$cloneResult = shell_exec("cd {$this->installPath} && git clone {$this->repositoryUrl} .");

		if (is_bool($cloneResult) && empty($cloneResult)) {
			throw new InstallationException('Failed to clone repository.');
		}

		$this->logger->write("Repository cloned successfully.", 25);

		return $this;
	}

	protected function configEnvironmentVariables(): self
	{
		// Backend
		$this->backendEnvHelper->set('APP_NAME', $this->installationData[RequestParam::APP_NAME->value]);
		$this->backendEnvHelper->set('DB_DATABASE', $this->installationData[RequestParam::DB_NAME->value]);
		$this->backendEnvHelper->set('DB_USERNAME', $this->installationData[RequestParam::DB_USER->value]);
		$this->backendEnvHelper->set('DB_PASSWORD', $this->installationData[RequestParam::DB_PASSWORD->value]);

		// Frontend
		$this->frontendEnvHelper->set('APP_NAME', $this->installationData[RequestParam::APP_NAME->value]);

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
