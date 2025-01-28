<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\PerformanceMetric;
use App\Services\ServerPerformanceService;
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
        $cpu = ServerPerformanceService::getCpuUsage();
        $memory = ServerPerformanceService::getMemoryUsage();

        $this->info("CPU: {$cpu} %");
        $this->info("Memory: available: {$memory['available']} MB, total: {$memory['total']} MB");

        PerformanceMetric::insert([
            'cpu_usage' => $cpu,
            'memory_usage' => $memory['total'] - $memory['available'],
            'collected_at' => now(),
        ]);
    }
}
