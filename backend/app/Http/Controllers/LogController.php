<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiNotFoundException;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    /**
     * Get latest logs.
     */
    public function __invoke(): JsonResponse
    {
        $logFile = storage_path('logs/laravel.log');

        throw_if(! file_exists($logFile), new ApiNotFoundException('Log file not found'));

        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $parsedLogs = array_map(function ($log) {
            return $this->parseLogLine($log);
        }, $logs);

        $filteredLogs = array_filter($parsedLogs);
        $recentLogs = array_slice(array_reverse($filteredLogs), 0, 15);

        return ApiResponse::create($recentLogs);
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
