<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Facades\Backup;
use Illuminate\Console\Command;

class CreateDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create {--f|filename= : Backup filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database backup';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $createdBackup = Backup::createDatabaseBackup($this->option('filename'));

        $this->info("Database backup creation started. Filename: {$createdBackup}");

        return self::SUCCESS;
    }
}
