<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Facades\Server;
use App\Models\SystemReport;
use App\Models\User;
use App\Notifications\SystemStatusWarning;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

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

        $this->sendWarnings($databaseStatus, $cacheStatus, $cpu, $ram);
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

    private function sendWarnings(bool $databaseStatus, bool $cacheStatus, float $cpu, array $ram): void
    {
        $warnings = collect();
        if (! $databaseStatus) {
            $warnings->push('Database connection is down');
        }

        if (! $cacheStatus) {
            $warnings->push('Cache connection is down');
        }

        if ($cpu > 80) {
            $warnings->push("CPU usage is high, {$cpu} %");
        }

        if ($ram['used'] / $ram['total'] > 0.8) {
            $warnings->push("RAM usage is high, {$ram['used']} MB used of {$ram['total']} MB total");
        }

        if ($warnings->isNotEmpty()) {
            $admins = User::whereHas('role', fn (Builder $query): Builder => $query->where('name', UserRole::ADMIN));

            Notification::send($admins, new SystemStatusWarning($warnings));
        }
    }
}
