<?php

declare(strict_types=1);

namespace PageCraft;

class Log
{
    protected string $filename = 'install.log';

    public function write(string $message, int $progress): void
    {
        $logData = [
            'status' => $message,
            'progress' => $progress
        ];

        file_put_contents($this->filename, json_encode($logData) . PHP_EOL, FILE_APPEND);
    }

    public function clear(): void
    {
        file_put_contents($this->filename, '');
    }

    public function getProgress(): int
    {
        $logData = $this->getLastLog();

        return empty($logData) ? 0 : $logData['progress'];
    }

    public function getStatus(): string
    {
        $logData = $this->getLastLog();

        return empty($logData) ? '' : $logData['status'];
    }

    protected function getLastLog(): array
    {
        if (file_exists($this->filename)) {
            $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lastLog = end($lines);

            return json_decode($lastLog, true);
        }

        return [];
    }
}
