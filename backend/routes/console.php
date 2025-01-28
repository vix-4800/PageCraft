<?php

declare(strict_types=1);

use App\Console\Commands\CollectPerformanceMetrics;
use App\Console\Commands\CreateDatabaseBackup;
use Illuminate\Console\Scheduling\Schedule as ScheduleContract;
use Illuminate\Support\Facades\Schedule;

Schedule::call(CreateDatabaseBackup::class)->dailyAt('01:00')->days([ScheduleContract::SUNDAY, ScheduleContract::WEDNESDAY]);
Schedule::call(CollectPerformanceMetrics::class)->everyTenMinutes();
