<?php

declare(strict_types=1);

class DatabaseConfigurator
{
	public function __construct(
		protected array $installationData,
		protected string $installPath
	) {
		// 
	}

	/**
	 * Configures the database for the backend. This method sets the database name, username, and password.
	 */
	public function configure(): void
	{
		$this->setDatabaseName();
		$this->setDatabaseUsername();
		$this->setDatabasePassword();
	}

	protected function setDatabaseName(): void
	{
		$this->setEnv('DB_DATABASE', $this->installationData[RequestParam::DB_NAME->value]);
	}

	protected function setDatabaseUsername(): void
	{
		$this->setEnv('DB_USERNAME', $this->installationData[RequestParam::DB_USER->value]);
	}

	protected function setDatabasePassword(): void
	{
		$this->setEnv('DB_PASSWORD', $this->installationData[RequestParam::DB_PASSWORD->value]);
	}

	protected function setEnv(string $key, string $value): void
	{
		$envFile = "$this->installPath/backend/.env";
		$envContent = file_get_contents($envFile);
		$envContent = str_replace("{$key}=", "{$key}={$value}", $envContent);
		file_put_contents($envFile, $envContent);
	}
}
