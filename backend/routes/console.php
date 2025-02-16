<?php

declare(strict_types=1);

use App\Console\Commands\Backup\CreateDatabaseBackup;
use App\Console\Commands\Backup\DeleteOldBackups;
use App\Console\Commands\CollectPerformanceMetrics;
use App\Models\OneTimePassword;
use Illuminate\Console\Scheduling\Schedule as ScheduleContract;
use Illuminate\Support\Facades\Schedule;
use Laravel\Telescope\Console\PruneCommand;

// Backups
Schedule::command(CreateDatabaseBackup::class)->dailyAt('01:00')->days([ScheduleContract::SUNDAY, ScheduleContract::WEDNESDAY]);
Schedule::command(DeleteOldBackups::class)->daily();

// Performance monitoring
Schedule::command(CollectPerformanceMetrics::class)->everyTenMinutes();

Schedule::command(PruneCommand::class)->daily();

// Delete expired one-time passwords
Schedule::call(fn () => OneTimePassword::where('expires_at', '<', now())->delete())->everyMinute();
