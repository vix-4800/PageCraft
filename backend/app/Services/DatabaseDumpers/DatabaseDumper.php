<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Helpers\DatabaseBackup;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

abstract class DatabaseDumper
{
    protected string $backupDir;

    public function __construct(?string $backupDir = null)
    {
        $this->backupDir = $backupDir ?? storage_path('app/backups');

        if (! is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }

    /**
     * Get the backup directory path.
     */
    public function getBackupDirectory(): string
    {
        return $this->backupDir;
    }

    /**
     * Create a database backup.
     *
     * @throws \App\Exceptions\DatabaseBackupException
     */
    abstract public function create(string $filename): void;

    /**
     * Restore a database backup.
     *
     * @throws \App\Exceptions\DatabaseBackupException
     */
    abstract public function restore(string $filename): void;

    /**
     * Get a list of all available backups.
     */
    public function list(): Collection
    {
        $backups = collect();

        if (! is_dir($this->backupDir)) {
            return $backups;
        }

        $files = scandir($this->backupDir);
        if (! $files) {
            return $backups;
        }

        $files = array_filter($files, fn (string $file): bool => pathinfo($file, PATHINFO_EXTENSION) === 'sql');
        foreach ($files as $file) {
            $backups->push((new DatabaseBackup("{$this->backupDir}/{$file}"))->toArray());
        }

        return $backups;
    }

    /**
     * Delete a database backup.
     */
    public function delete(string $file): void
    {
        unlink("{$this->backupDir}/{$file}");
    }

    /**
     * Delete all database backups.
     */
    public function deleteAll(): void
    {
        /** @var array{name: string, size: int|float, date: Carbon} $backupFile */
        foreach ($this->list() as $backupFile) {
            $this->delete($backupFile['name']);
        }
    }
}
