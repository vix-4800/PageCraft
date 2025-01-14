<?php

declare(strict_types=1);

require_once __DIR__ . 'RequestParam.php';

class Installer
{
	protected string $repositoryUrl = 'https://github.com/vix-4800/PageCraft.git';

	protected string $installPath = './PageCraft';

	public function __construct(
		protected array $installationData
	) {
		// 
	}

	public function install(): void
	{
		echo "Starting installation process...\n";

		$this->checkDependencies();

		if (is_dir($this->installPath)) {
			throw new RuntimeException("Installation path '{$this->installPath}' already exists.");
		}

		$this->cloneRepository();
		$this->configEnvironmentVariables();
		$this->installComposerDependencies();
		$this->installNodeDependencies();

		echo "Installation completed successfully.\n";

		$this->startDockerContainers();
		$this->runMigrations($this->installationData[RequestParam::RUN_SEEDERS->value] === 1);

		echo "Containers started successfully.\n";
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

		echo "Dependencies checked: Git and Docker are available.\n";
	}

	protected function cloneRepository(): void
	{
		@mkdir($this->installPath, 0755, true);

		$cloneResult = @shell_exec("cd {$this->installPath} && git clone {$this->repositoryUrl} .");

		if (is_bool($cloneResult) && empty($cloneResult)) {
			throw new RuntimeException('Failed to clone repository.');
		}

		echo "Repository cloned successfully.\n";
	}

	protected function configEnvironmentVariables(): void
	{
		// Backend
		@shell_exec("cp {$this->installPath}/backend/.env.example {$this->installPath}/backend/.env");

		$backendEnvContent = file_get_contents("{$this->installPath}/backend/.env");
		$backendEnvContent = str_replace('APP_NAME=PageCraft', "APP_NAME={$this->installationData[RequestParam::APP_NAME->value]}", $backendEnvContent);
		file_put_contents("{$this->installPath}/backend/.env", $backendEnvContent);

		// Frontend
		@shell_exec("cp {$this->installPath}/frontend/.env.example {$this->installPath}/frontend/.env");

		$frontendEnvContent = file_get_contents("{$this->installPath}/frontend/.env");
		$frontendEnvContent = str_replace('APP_NAME=PageCraft', "APP_NAME={$this->installationData[RequestParam::APP_NAME->value]}", $frontendEnvContent);
		file_put_contents("{$this->installPath}/frontend/.env", $frontendEnvContent);

		echo "Environment variables configured successfully.\n";
	}

	protected function installComposerDependencies(): void
	{
		@shell_exec("cd {$this->installPath}/backend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts");

		echo "Composer dependencies installed.\n";
	}

	protected function installNodeDependencies(): void
	{
		@shell_exec("cd {$this->installPath}/frontend && docker run --rm -v $(pwd):/var/www/html -w /var/www/html node:22-alpine npm install --force");

		echo "Node.js dependencies installed.\n";
	}

	protected function startDockerContainers(): void
	{
		@shell_exec("cd {$this->installPath} && docker compose -f backend/docker-compose.yml up -d && docker compose -f frontend/docker-compose.yml up -d");

		echo "Docker containers started.\n";
	}

	protected function runMigrations(bool $withSeeders = false): void
	{
		@shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan migrate --force");

		if ($withSeeders) {
			@shell_exec("cd {$this->installPath}/backend && docker exec -it backend php artisan db:seed");
		}
	}
}
