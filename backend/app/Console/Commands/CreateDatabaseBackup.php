<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\DatabaseBackupService;
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
        $filename = $this->option('filename') ?? 'backup_'.date('Y_m_d_H_i_s').'_'.Str::random(8).'.sql';
        $backupDir = (new DatabaseBackupService)->getBackupDirectory();
        $filepath = "{$backupDir}/{$filename}";

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($filepath)
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        if ($returnVar !== $this::SUCCESS) {
            $this->error('Database backup failed.');
        } else {
            $this->info("Database backup created successfully: {$filename}");
        }

        return $returnVar;
    }
}
