<?php

declare(strict_types=1);

namespace PageCraft;

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
		return explode("{$key}=", $this->getEnvContent())[1];
	}

	public function set(string $key, string $value): void
	{
		$this->writeToEnvFile(
			str_replace("{$key}=", "{$key}={$value}", $this->getEnvContent())
		);
	}

	public function delete(string $key): void
	{
		$this->writeToEnvFile(
			str_replace("{$key}=", "", $this->getEnvContent())
		);
	}

	public function exists(string $key): bool
	{
		return strpos($this->getEnvContent(), "{$key}=") !== false;
	}

	protected function getEnvContent(): string
	{
		return file_get_contents($this->envFile);
	}

	protected function writeToEnvFile(string $content): void
	{
		file_put_contents($this->envFile, $content);
	}

	public function createFromExample(): void
	{
		exec("cp {$this->directory}/.env.example {$this->directory}/.env");
	}
}
