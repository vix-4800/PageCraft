<?php

declare(strict_types=1);

require_once __DIR__ . '/RequestParam.php';
require_once __DIR__ . '/DatabaseConfigurator.php';

class Installer
{
	protected string $repositoryUrl = 'https://github.com/vix-4800/PageCraft.git';

	protected string $installPath;

	public function __construct(
		protected array $installationData
	) {
		$this->installPath = $this->installationData[RequestParam::INSTALL_PATH->value] . '/pagecraft';

		file_put_contents("install.log", '');
	}

	public function install(): void
	{
		$this->log("Starting installation process...", 0);

		$this->checkDependencies();
		$this->validateInstallPath();

		$this->cloneRepository();
		$this->configEnvironmentVariables();
		$this->installComposerDependencies();
		$this->installNodeDependencies();

		$this->log("Installation completed successfully.", 60);

		$this->startDockerContainers();

		$databaseConfigurator = new DatabaseConfigurator($this->installationData, $this->installPath);
		$databaseConfigurator->configure();

		$this->generateAppKey();
		$this->runMigrations($this->installationData[RequestParam::RUN_SEEDERS->value] === 1);
		$this->storageLink();

		$this->log("Containers started successfully.", 100);
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

		$this->log("Dependencies checked: Git and Docker are available.", 10);
	}

	protected function cloneRepository(): void
	{
		mkdir($this->installPath, 0755, true);

		$cloneResult = shell_exec("cd {$this->installPath} && git clone {$this->repositoryUrl} .");

		if (is_bool($cloneResult) && empty($cloneResult)) {
			throw new RuntimeException('Failed to clone repository.');
		}

		$this->log("Repository cloned successfully.", 25);
	}

	protected function configEnvironmentVariables(): void
	{
		// Backend
		shell_exec("cp {$this->installPath}/backend/.env.example {$this->installPath}/backend/.env");

		$backendEnvContent = file_get_contents("{$this->installPath}/backend/.env");
		$backendEnvContent = str_replace('APP_NAME=PageCraft', "APP_NAME={$this->installationData[RequestParam::APP_NAME->value]}", $backendEnvContent);
		file_put_contents("{$this->installPath}/backend/.env", $backendEnvContent);

		// Frontend
		shell_exec("cp {$this->installPath}/frontend/.env.example {$this->installPath}/frontend/.env");

		$frontendEnvContent = file_get_contents("{$this->installPath}/frontend/.env");
		$frontendEnvContent = str_replace('APP_NAME=PageCraft', "APP_NAME={$this->installationData[RequestParam::APP_NAME->value]}", $frontendEnvContent);
		file_put_contents("{$this->installPath}/frontend/.env", $frontendEnvContent);

		$this->log("Environment variables configured successfully.", 30);
	}

	protected function installComposerDependencies(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts");

		$this->log("Composer dependencies installed.", 45);
	}

	protected function installNodeDependencies(): void
	{
		shell_exec("cd {$this->installPath}/frontend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html node:22-alpine npm install --force");

		$this->log("Node.js dependencies installed.", 55);
	}

	protected function startDockerContainers(): void
	{
		shell_exec("cd {$this->installPath} && docker compose -f backend/docker-compose.yml up -d && docker compose -f frontend/docker-compose.yml up -d");

		$this->log("Docker containers started.", 75);
	}

	protected function generateAppKey(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan key:generate");

		$this->log("App key generated.", 80);
	}

	protected function runMigrations(bool $withSeeders = false): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan migrate --force");

		if ($withSeeders) {
			shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan db:seed");
		}

		$this->log("Migrations run.", 90);
	}

	protected function storageLink(): void
	{
		shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan storage:link");

		$this->log("Storage linked.", 95);
	}

	public function log(string $message, int $progress): void
	{
		$logData = [
			'status' => $message,
			'progress' => $progress
		];

		file_put_contents("install.log", json_encode($logData) . PHP_EOL, FILE_APPEND);
	}
}
