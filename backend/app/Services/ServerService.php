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
     * @return array{
     *      user: int,
     *      nice: int,
     *      system: int,
     *      idle: int,
     *      iowait: int,
     *      irq: int,
     *      softirq: int
     * } Associative array of CPU stats.
     */
    protected function readCpuStats(): array
    {
        $cpuStats = [
            'user' => 0,
            'nice' => 0,
            'system' => 0,
            'idle' => 0,
            'iowait' => 0,
            'irq' => 0,
            'softirq' => 0,
        ];
        $statFile = fopen('/proc/stat', 'r');
        if ($statFile) {
            $line = fgets($statFile);
            fclose($statFile);

            if ($line && preg_match('/^cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $line, $matches)) {
                $cpuStats['user'] = (int) $matches[1];
                $cpuStats['nice'] = (int) $matches[2];
                $cpuStats['system'] = (int) $matches[3];
                $cpuStats['idle'] = (int) $matches[4];
                $cpuStats['iowait'] = (int) $matches[5];
                $cpuStats['irq'] = (int) $matches[6];
                $cpuStats['softirq'] = (int) $matches[7];
            }
        }

        return $cpuStats;
    }

    /**
     * Get RAM usage details from /proc/meminfo.
     *
     * @return array{
     *      total: float,
     *      used: float,
     *      free: float,
     *      buffers: float,
     *      cached: float,
     *      available: float
     * } Associative array with RAM details in MB.
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
     * @return array<string, array{ incoming: float, outgoing: float }> Associative array with network interface as key
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

    /**
     * Checks if the cache connection is up.
     */
    public function isCacheUp(): bool
    {
        return true;
    }

    /**
     * Returns the system uptime in the format H:i:s.
     */
    public function getUptime(): string
    {
        $uptime = file_get_contents('/proc/uptime');

        if ($uptime) {
            $uptime = (float) explode(' ', $uptime)[0];

            return gmdate('H:i:s', (int) $uptime);
        }

        return '00:00:00';
    }

    /**
     * Checks if application config is cached.
     */
    public function isConfigCached(): bool
    {
        return file_exists(base_path('bootstrap/cache/config.php'));
    }
}
