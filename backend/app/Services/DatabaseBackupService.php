<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DatabaseBackupException;
use App\Helpers\DatabaseBackup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupService
{
    private string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
    }

    /**
     * @throws DatabaseBackupException
     */
    public function create(): void
    {
        if (! is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }

        throw_unless(Artisan::call('backup:create') == Command::SUCCESS, new DatabaseBackupException('Failed to create database backup.'));
    }

    public function list(): array
    {
        if (! is_dir($this->backupDir)) {
            return [];
        }

        $backups = collect();
        $files = scandir($this->backupDir);
        $files = array_filter($files, fn ($file): bool => pathinfo($file, PATHINFO_EXTENSION) === 'sql');

        foreach ($files as $file) {
            $backups->push((new DatabaseBackup("{$this->backupDir}/{$file}"))->toArray());
        }

        return $backups->toArray();
    }

    public function delete(string $file): void
    {
        unlink("{$this->backupDir}/{$file}");
    }

    public function deleteAll(): void
    {
        foreach ($this->list() as $file) {
            $this->delete($file);
        }
    }

    /**
     * Get the backup directory path.
     */
    public function getBackupDirectory(): string
    {
        return $this->backupDir;
    }
}
