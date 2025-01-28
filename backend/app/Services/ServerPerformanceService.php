<?php

declare(strict_types=1);

namespace App\Services;

class ServerPerformanceService
{
    /**
     * Get the current CPU usage.
     *
     * @return float The current CPU load average over the last minute, or 0 if not available.
     */
    public static function getCpuUsage(): float
    {
        $stat1 = self::readCpuStats();
        sleep(1);
        $stat2 = self::readCpuStats();

        $deltaTotal = array_sum($stat2) - array_sum($stat1);
        $deltaIdle = $stat2['idle'] - $stat1['idle'];

        $usage = 100 * (($deltaTotal - $deltaIdle) / $deltaTotal);

        return round($usage, 2);
    }

    /**
     * Read CPU stats from /proc/stat.
     *
     * @return array Associative array of CPU stats.
     */
    private static function readCpuStats(): array
    {
        $cpuStats = [];
        $statFile = fopen('/proc/stat', 'r');
        if ($statFile) {
            $line = fgets($statFile);
            fclose($statFile);

            if (preg_match('/^cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $line, $matches)) {
                $cpuStats = [
                    'user' => (int) $matches[1],
                    'nice' => (int) $matches[2],
                    'system' => (int) $matches[3],
                    'idle' => (int) $matches[4],
                    'iowait' => (int) $matches[5],
                    'irq' => (int) $matches[6],
                    'softirq' => (int) $matches[7],
                ];
            }
        }

        return $cpuStats;
    }

    /**
     * Get RAM usage details from /proc/meminfo.
     *
     * @return array Associative array with RAM details in MB.
     */
    public static function getMemoryUsage(): array
    {
        $memInfo = [];
        $file = fopen('/proc/meminfo', 'r');

        if ($file) {
            while (($line = fgets($file)) !== false) {
                if (preg_match('/^(\w+):\s+(\d+)/', $line, $matches)) {
                    $key = $matches[1];
                    $value = (int) $matches[2]; // Значение в кБ.
                    $memInfo[$key] = round($value / 1024, 2); // Переводим в МБ.
                }
            }
            fclose($file);
        }

        return [
            'total' => $memInfo['MemTotal'] ?? 0,
            'free' => $memInfo['MemFree'] ?? 0,
            'buffers' => $memInfo['Buffers'] ?? 0,
            'cached' => $memInfo['Cached'] ?? 0,
            'available' => $memInfo['MemAvailable'] ?? 0,
        ];
    }
}
