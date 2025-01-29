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
        $ram = Server::getMemoryUsage();

        $this->info("CPU: {$cpu} %");
        $this->info("Memory: free: {$ram['free']} MB, total: {$ram['total']} MB");

        PerformanceMetric::insert([
            'cpu_usage' => $cpu,
            'ram_usage' => $ram['total'] - $ram['free'] - $ram['buffers'] - $ram['cached'],
            'ram_total' => $ram['total'],
            'collected_at' => now(),
        ]);
    }
}
