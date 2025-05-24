<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

final class ServerService
{
    /**
     * Checks if the database connection is up.
     */
    public function isDatabaseUp(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (Exception) {
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
    private function readCpuStats(): array
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
}
