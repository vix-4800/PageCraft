<?php

declare(strict_types=1);

namespace PageCraft;

class Env
{
    protected string $envFile;

    public function __construct(
        protected readonly string $directory
    ) {
        $this->envFile = "{$this->directory}/.env";
    }

    public function get(string $key): ?string
    {
        $pattern = "/^{$key}=(.*)$/m";

        if (preg_match($pattern, $this->getEnvContent(), $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    public function set(string $key, string $value): void
    {
        $envContent = $this->getEnvContent();
        $pattern = "/^{$key}=.*$/m";

        $value = empty($value) ? $value : "\"{$value}\"";

        $newContent = preg_match($pattern, $envContent)
            ? preg_replace($pattern, "{$key}={$value}", $envContent)
            : $envContent . PHP_EOL . "{$key}={$value}";

        $this->writeToEnvFile($newContent);
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
