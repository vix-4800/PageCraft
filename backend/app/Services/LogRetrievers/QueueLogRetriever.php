<?php

declare(strict_types=1);

namespace App\Services\LogRetrievers;

final class QueueLogRetriever extends LogRetriever
{
    public function __construct(string $logFilename)
    {
        $this->logFile = storage_path("logs/{$logFilename}");
    }

    protected function parseLogLine(string $log): ?array
    {
        $pattern = '/^\s\s(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})\s([\w\\\\]+)\s+\.{1,}\s(\d+(?:\.\d+)ms)\s(DONE|FAIL)$/';

        if (preg_match($pattern, $log, $matches)) {
            $name = explode('\\', $matches[2]);
            $name = end($name);

            return [
                'date' => $matches[1],
                'name' => $matches[2],
                'execution_time' => $matches[3],
                'status' => $matches[4],
            ];
        }

        return null;
    }
}
