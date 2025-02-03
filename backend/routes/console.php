<?php

declare(strict_types=1);

use App\Console\Commands\Backup\CreateDatabaseBackup;
use App\Console\Commands\Backup\DeleteOldBackups;
use App\Console\Commands\CollectPerformanceMetrics;
use Illuminate\Console\Scheduling\Schedule as ScheduleContract;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CreateDatabaseBackup::class)->dailyAt('01:00')->days([ScheduleContract::SUNDAY, ScheduleContract::WEDNESDAY]);
Schedule::command(CollectPerformanceMetrics::class)->everyTenMinutes();
Schedule::command(DeleteOldBackups::class)->daily();
