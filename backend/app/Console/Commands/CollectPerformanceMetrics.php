<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Server;
use App\Models\PerformanceMetric;
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

        $this->info("CPU: {$cpu} %");
        $this->info("Memory: {$ram['used']} MB / {$ram['total']} MB");
        $this->info("Network: {$network['eth0']['incoming']} B / {$network['eth0']['outgoing']} B");

        PerformanceMetric::create([
            'cpu_usage' => $cpu,
            'ram_usage' => $ram['used'],
            'ram_total' => $ram['total'],
            'network_incoming' => $network['eth0']['incoming'],
            'network_outgoing' => $network['eth0']['outgoing'],
        ]);
    }
}
