<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Helpers\DatabaseBackup;
use App\Services\DatabaseBackup\DatabaseBackupService;
use Illuminate\Console\Command;

class DeleteOldBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old backups (older than 1 month)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $service = resolve(DatabaseBackupService::class);

        $service->list()->each(function (DatabaseBackup $backup) use ($service): void {
            $period = config('backup.delete_after');

            $targetDate = match (config('backup.delete_after_method')) {
                'days' => now()->subDays($period),
                'weeks' => now()->subWeeks($period),
                'months' => now()->subMonths($period),
                'years' => now()->subYears($period),
            };

            if ($backup->getDate()->isBefore($targetDate)) {
                $service->delete($backup->getName());
            }
        });
    }
}
