<?php

declare(strict_types=1);

use App\Console\Commands\Backup\CreateDatabaseBackup;
use App\Console\Commands\Backup\DeleteOldBackups;
use App\Console\Commands\CollectPerformanceMetrics;
use App\Facades\Telegram;
use App\Jobs\TelegramUpdateHandler;
use App\Models\OneTimePassword;
use App\Models\SystemReport;
use Illuminate\Console\Scheduling\Schedule as ScheduleContract;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Facades\Schedule;
use Laravel\Telescope\Console\PruneCommand;

// Backups
Schedule::command(CreateDatabaseBackup::class)->dailyAt('01:00')->days([ScheduleContract::SUNDAY, ScheduleContract::WEDNESDAY]);
Schedule::command(DeleteOldBackups::class)->daily();

// Performance monitoring
Schedule::command(CollectPerformanceMetrics::class)->everyTenMinutes();
Schedule::call(fn () => SystemReport::where('collected_at', '<', now()->subWeek())->delete())->weekly();

Schedule::command(PruneCommand::class)->daily();

// Delete expired one-time passwords
Schedule::call(fn () => OneTimePassword::where('expires_at', '<', now())->delete())->everyMinute();

// Handle telegram updates
Schedule::call(fn (): PendingDispatch => TelegramUpdateHandler::dispatch(Telegram::getUpdates()))->everyFiveMinutes();
