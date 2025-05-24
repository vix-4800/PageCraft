<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Server;
use App\Models\SystemReport;
use Illuminate\Console\Command;

final class CollectPerformanceMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metrics:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect performance metrics for the server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $databaseStatus = Server::isDatabaseUp();
        $cacheStatus = Server::isCacheUp();
        $upTime = Server::getUptime();
        $configCached = Server::isConfigCached();

        SystemReport::create([
            'is_database_up' => $databaseStatus,
            'is_cache_up' => $cacheStatus,
            'uptime' => $upTime,
        ]);

        $this->printResults($databaseStatus, $cacheStatus, $upTime, $configCached);
    }

    private function printResults(bool $databaseStatus, bool $cacheStatus, string $upTime, bool $configCached): void
    {
        $this->info('Database up: '.($databaseStatus ? 'yes' : 'no'));
        $this->info('Cache up: '.($cacheStatus ? 'yes' : 'no'));
        $this->info('Uptime: '.$upTime);
        $this->info('Config cached: '.($configCached ? 'yes' : 'no'));
    }
}
