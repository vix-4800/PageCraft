<?php

declare(strict_types=1);

namespace App\Services\LogRetrievers;

abstract class LogRetriever
{
    protected string $logFile;

    /**
     * Parse a log line into an array of log data.
     *
     * @param  string  $log  The log line to parse.
     * @return array<string, mixed>|null An array of log data, or null if the log line could not be parsed.
     */
    abstract protected function parseLogLine(string $log): ?array;

    /**
     * Get the path to the log file being retrieved.
     */
    final public function getLogFile(): string
    {
        return $this->logFile;
    }

    /**
     * Retrieve the last {$limit} log entries from the log file.
     *
     * Returns an array of log entries, each of which is an associative array.
     * If the log file does not exist or is empty, an empty array will be returned.
     *
     * @return array<int, array<string, mixed>>
     */
    final public function retrieve(int $limit = 15): array
    {
        if (! $this->checkLogFile()) {
            return [];
        }

        $logs = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($logs === [] || $logs === false) {
            return [];
        }

        $parsedLogs = array_map(fn ($log): ?array => $this->parseLogLine($log), $logs);

        $filteredLogs = array_filter($parsedLogs);

        return array_slice(array_reverse($filteredLogs), 0, $limit);
    }

    /**
     * Delete the log file if it exists.
     */
    final public function clear(): void
    {
        if ($this->checkLogFile()) {
            unlink($this->logFile);
        }
    }

    /**
     * Check if the log file exists.
     *
     * @return bool True if the log file exists, false otherwise.
     */
    protected function checkLogFile(): bool
    {
        return file_exists($this->logFile);
    }
}
