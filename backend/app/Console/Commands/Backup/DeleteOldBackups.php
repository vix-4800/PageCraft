<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Helpers\DatabaseBackup;
use App\Services\DatabaseDumpers\DatabaseDumper;
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
        $service = resolve(DatabaseDumper::class);

        $service->list()->each(function (DatabaseBackup $backup) use ($service): void {
            if ($backup->getDate()->isBefore(now()->subMonth())) {
                $service->delete($backup->getName());
            }
        });
    }
}
