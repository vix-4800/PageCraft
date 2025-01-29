<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

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
    abstract public function create(): void;

    /**
     * Get a list of all available backups.
     */
    abstract public function list(): Collection;

    /**
     * Delete a database backup.
     */
    abstract public function delete(string $file): void;

    /**
     * Delete all database backups.
     */
    abstract public function deleteAll(): void;
}
