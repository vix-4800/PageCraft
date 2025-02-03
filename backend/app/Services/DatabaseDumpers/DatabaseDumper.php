<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Helpers\DatabaseBackup;
use Illuminate\Support\Collection;

abstract class DatabaseDumper
{
    protected string $backupDir;

    protected string $databaseUsername;

    protected string $databasePassword;

    protected string $databaseName;

    protected string $databaseHost;

    public function __construct()
    {
        $this->backupDir = config('backup.directory');

        if (! is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }

        $driver = config('database.default');

        $this->databaseUsername = config("database.connections.{$driver}.username");
        $this->databasePassword = config("database.connections.{$driver}.password");
        $this->databaseName = config("database.connections.{$driver}.database");
        $this->databaseHost = config("database.connections.{$driver}.host");
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
     *
     * @return Collection<DatabaseBackup>
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
            $backups->push(new DatabaseBackup("{$this->backupDir}/{$file}"));
        }

        return $backups;
    }

    /**
     * Delete a database backup.
     */
    public function delete(string $filename): void
    {
        unlink("{$this->backupDir}/{$filename}");
    }

    /**
     * Delete all database backups.
     */
    public function deleteAll(): void
    {
        $this->list()->each(fn (DatabaseBackup $backupFile) => $this->delete($backupFile->getName()));
    }
}
