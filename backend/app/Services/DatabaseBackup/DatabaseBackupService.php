<?php

declare(strict_types=1);

namespace App\Services\DatabaseBackup;

use App\Exceptions\DatabaseBackupException;
use App\Helpers\DatabaseBackup;
use Illuminate\Support\Collection;

abstract class DatabaseBackupService
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

        $this->databaseName = config(sprintf('database.connections.%s.database', $driver));
        if ($driver !== 'sqlite') {
            $this->databaseUsername = config(sprintf('database.connections.%s.username', $driver));
            $this->databasePassword = config(sprintf('database.connections.%s.password', $driver));
            $this->databaseHost = config(sprintf('database.connections.%s.host', $driver));
        }
    }

    /**
     * Create a database backup.
     *
     * @throws DatabaseBackupException
     */
    abstract public function create(string $filename): string;

    /**
     * Restore a database backup.
     *
     * @throws DatabaseBackupException
     */
    abstract public function restore(string $filename): void;

    /**
     * Get the backup directory path.
     */
    final public function getBackupDirectory(): string
    {
        return $this->backupDir;
    }

    /**
     * Get a list of all available backups.
     *
     * @return Collection<DatabaseBackup>
     */
    final public function list(): Collection
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
            $backups->push(new DatabaseBackup(sprintf('%s/%s', $this->backupDir, $file)));
        }

        return $backups;
    }

    /**
     * Delete a database backup.
     */
    final public function delete(string $filename): void
    {
        unlink(sprintf('%s/%s', $this->backupDir, $filename));
    }

    /**
     * Delete all database backups.
     */
    final public function deleteAll(): void
    {
        $this->list()->each(fn (DatabaseBackup $databaseBackup) => $this->delete($databaseBackup->getName()));
    }
}
