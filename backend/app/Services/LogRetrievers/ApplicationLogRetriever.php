<?php

declare(strict_types=1);

namespace App\Services\LogRetrievers;

class ApplicationLogRetriever extends LogRetriever
{
    public function __construct()
    {
        $this->logFile = storage_path('logs/laravel.log');
    }

    /**
     * @return array{
     *     date: string,
     *     level: string,
     *     message: string
     * }|null
     */
    protected function parseLogLine(string $log): ?array
    {
        $pattern = '/^\[(.*?)\]\s(\w+)\.(\w+):\s(.*)$/';

        return preg_match($pattern, $log, $matches)
            ? [
                'date' => $matches[1],
                'level' => $matches[3],
                'message' => $matches[4],
            ]
            : null;
    }

    public function getErrorLogsCount(): int
    {
        if ($this->checkLogFile()) {
            $content = file_get_contents($this->logFile);

            if ($content === false) {
                return 0;
            }

            return substr_count($content, 'ERROR');
        }

        return 0;
    }
}
