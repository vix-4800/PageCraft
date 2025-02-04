<?php

declare(strict_types=1);

namespace App\Console\Commands\Backup;

use App\Facades\Backup;
use Illuminate\Console\Command;

class RestoreDatabaseFromBackup extends Command
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
        $filename = $this->argument('filename');
        $filename .= str_ends_with($filename, '.sql') ? '' : '.sql';

        Backup::restoreDatabaseBackup($filename);

        $this->info("Database restore started. Filename: {$filename}");

        return self::SUCCESS;
    }
}
