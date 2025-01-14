<?php

declare(strict_types=1);

class Env
{
	public function __construct(
		private readonly string $path
	) {
		// 
	}

	public function get(string $key): string
	{
		$envContent = file_get_contents($this->path);

		return explode("{$key}=", $envContent)[1];
	}

	public function set(string $key, string $value): void
	{
		$envContent = file_get_contents($this->path);
		$envContent = str_replace("{$key}=", "{$key}={$value}", $envContent);
		file_put_contents($this->path, $envContent);
	}

	public function delete(string $key): void
	{
		$envContent = file_get_contents($this->path);
		$envContent = str_replace("{$key}=", "", $envContent);
		file_put_contents($this->path, $envContent);
	}

	public function exists(string $key): bool
	{
		$envContent = file_get_contents($this->path);
		return strpos($envContent, "{$key}=") !== false;
	}
}
