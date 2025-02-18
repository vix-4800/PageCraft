<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Server;
use App\Models\SystemReport;
use Illuminate\Console\Command;

class CollectPerformanceMetrics extends Command
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
        $cpu = Server::getCpuUsage();
        $ram = Server::getRamUsage();
        $network = Server::getNetworkUsage();
        $databaseStatus = Server::isDatabaseUp();
        $cacheStatus = Server::isCacheUp();
        $upTime = Server::getUptime();
        $configCached = Server::isConfigCached();

        SystemReport::create([
            'cpu_usage' => $cpu,
            'ram_usage' => $ram['used'],
            'ram_total' => $ram['total'],
            'network_incoming' => $network['eth0']['incoming'],
            'network_outgoing' => $network['eth0']['outgoing'],
            'is_database_up' => $databaseStatus,
            'is_cache_up' => $cacheStatus,
            'uptime' => $upTime,
        ]);

        $this->printResults($databaseStatus, $cacheStatus, $cpu, $ram, $network, $upTime, $configCached);
    }

    private function printResults(bool $databaseStatus, bool $cacheStatus, float $cpu, array $ram, array $network, string $upTime, bool $configCached): void
    {
        $this->info("CPU: {$cpu} %");
        $this->info("Memory: {$ram['used']} MB / {$ram['total']} MB");
        $this->info("Network: {$network['eth0']['incoming']} B / {$network['eth0']['outgoing']} B");
        $this->info('Database up: '.($databaseStatus ? 'yes' : 'no'));
        $this->info('Cache up: '.($cacheStatus ? 'yes' : 'no'));
        $this->info("Uptime: {$upTime}");
        $this->info('Config cached: '.($configCached ? 'yes' : 'no'));
    }
}
