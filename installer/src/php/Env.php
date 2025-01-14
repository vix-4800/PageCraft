<?php

declare(strict_types=1);

class Env
{
	private string $envFile;

	public function __construct(
		private readonly string $directory
	) {
		$this->envFile = "{$this->directory}/.env";

		if (!file_exists($this->envFile)) {
			$this->createFromExample();
		}
	}

	public function get(string $key): string
	{
		$envContent = file_get_contents($this->envFile);

		return explode("{$key}=", $envContent)[1];
	}

	public function set(string $key, string $value): void
	{
		$envContent = file_get_contents($this->envFile);
		$envContent = str_replace("{$key}=", "{$key}={$value}", $envContent);
		file_put_contents($this->envFile, $envContent);
	}

	public function delete(string $key): void
	{
		$envContent = file_get_contents($this->envFile);
		$envContent = str_replace("{$key}=", "", $envContent);
		file_put_contents($this->envFile, $envContent);
	}

	public function exists(string $key): bool
	{
		$envContent = file_get_contents($this->envFile);
		return strpos($envContent, "{$key}=") !== false;
	}

	public function createFromExample(): void
	{
		exec("cp {$this->directory}/.env.example {$this->directory}/.env");
	}
}
