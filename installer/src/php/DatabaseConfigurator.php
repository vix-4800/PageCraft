<?php

declare(strict_types=1);

class DatabaseConfigurator
{
	private Env $envHelper;

	public function __construct(
		protected array $installationData,
		protected string $installPath
	) {
		$this->envHelper = new Env("{$this->installPath}/backend/.env");
	}

	/**
	 * Configures the database for the backend. This method sets the database name, username, and password.
	 */
	public function configure(): void
	{
		$this->envHelper->set('DB_DATABASE', $this->installationData[RequestParam::DB_NAME->value]);
		$this->envHelper->set('DB_USERNAME', $this->installationData[RequestParam::DB_USER->value]);
		$this->envHelper->set('DB_PASSWORD', $this->installationData[RequestParam::DB_PASSWORD->value]);
	}
}
