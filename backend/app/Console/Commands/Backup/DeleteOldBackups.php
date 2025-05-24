<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Facades\Backup;
use App\Helpers\DatabaseBackup;
use Illuminate\Console\Command;

final class DeleteOldBackups extends Command
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
        Backup::listDatabaseBackups()->each(function (DatabaseBackup $databaseBackup): void {
            $period = config('backup.delete_after');

            $targetDate = match (config('backup.delete_after_method')) {
                'days' => now()->subDays($period),
                'weeks' => now()->subWeeks($period),
                'months' => now()->subMonths($period),
                'years' => now()->subYears($period),
            };

            if ($databaseBackup->getDate()->isBefore($targetDate)) {
                Backup::deleteDatabaseBackup($databaseBackup->getName());
            }
        });
    }
}
