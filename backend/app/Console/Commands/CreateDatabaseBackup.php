<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\CreateDatabaseDump;
use Illuminate\Console\Command;
use Str;

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
        $filename = $this->option('filename') ?? 'backup_'.date('Y_m_d_H_i_s').'_'.Str::random(8);
        $filename .= str_ends_with($filename, '.sql') ? '' : '.sql';

        CreateDatabaseDump::dispatchSync($filename);

        $this->info("Database backup creation started. Filename: {$filename}");

        return self::SUCCESS;
    }
}
