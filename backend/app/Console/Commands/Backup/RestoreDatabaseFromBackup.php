<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Facades\Backup;
use Illuminate\Console\Command;

final class RestoreDatabaseFromBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore {filename : Backup filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database from backup';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Backup::restoreDatabaseBackup($this->argument('filename'));

        $this->info('Database restore started.');

        return self::SUCCESS;
    }
}
