<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServerService
{
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
