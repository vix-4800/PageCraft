<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServerService
{
    /**
     * Get the current CPU usage.
     *
     * @return float The current CPU load average over the last minute, or 0 if not available.
     */
    public function getCpuUsage(): float
    {
        $stat1 = $this->readCpuStats();
        sleep(1);
        $stat2 = $this->readCpuStats();

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
    protected function readCpuStats(): array
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
    public function getRamUsage(): array
    {
        $memInfo = [];
        $file = fopen('/proc/meminfo', 'r');

        if ($file) {
            while (($line = fgets($file)) !== false) {
                if (preg_match('/^(\w+):\s+(\d+)/', $line, $matches)) {
                    $key = $matches[1];
                    $value = (int) $matches[2];
                    $memInfo[$key] = round($value / 1024, 2);
                }
            }
            fclose($file);
        }

        return [
            'total' => $memInfo['MemTotal'] ?? 0,
            'used' => round($memInfo['MemTotal'] - $memInfo['MemFree'] - $memInfo['Buffers'] - $memInfo['Cached'], 2),
            'free' => $memInfo['MemFree'] ?? 0,
            'buffers' => $memInfo['Buffers'] ?? 0,
            'cached' => $memInfo['Cached'] ?? 0,
            'available' => $memInfo['MemAvailable'] ?? 0,
        ];
    }

    /**
     * Read network interface statistics from /proc/net/dev.
     *
     * @return array Associative array with network interface as key, and an
     *               associative array as value with 'incoming' and 'outgoing' keys (in bytes).
     */
    public function getNetworkUsage(): array
    {
        $networkStats = [];
        $file = fopen('/proc/net/dev', 'r');

        if ($file) {
            while (($line = fgets($file)) !== false) {
                if (preg_match('/^\s*(\w+):\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+(\d+)/', $line, $matches)) {
                    $interface = $matches[1];
                    $rxBytes = (int) $matches[2]; // Incoming traffic.
                    $txBytes = (int) $matches[3]; // Outgoing traffic.

                    $networkStats[$interface] = [
                        'incoming' => round($rxBytes, 2),
                        'outgoing' => round($txBytes, 2),
                    ];
                }
            }
            fclose($file);
        }

        return $networkStats;
    }

    /**
     * Checks if the database connection is up.
     */
    public function isDatabaseUp(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
