<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    /**
     * Get latest logs.
     */
    public function getLogs(): JsonResponse
    {
        $logFile = storage_path('logs/laravel.log');

        if (! file_exists($logFile)) {
            return ApiResponse::create();
        }

        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $parsedLogs = array_map(fn ($log): ?array => $this->parseLogLine($log), $logs);

        $filteredLogs = array_filter($parsedLogs);
        $recentLogs = array_slice(array_reverse($filteredLogs), 0, 15);

        return ApiResponse::create($recentLogs);
    }

    public function deleteLogs(): JsonResponse
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            unlink($logFile);
        }

        return ApiResponse::create();
    }

    private function parseLogLine(string $log): ?array
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
}
