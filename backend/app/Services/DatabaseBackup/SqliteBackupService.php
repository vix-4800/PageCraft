<?php

declare(strict_types=1);

namespace App\Services\DatabaseBackup;

use App\Events\DatabaseDumpCreated;
use App\Exceptions\DatabaseBackupException;

final class SqliteBackupService extends DatabaseBackupService
{
    /**
     * The path to the SQLite database file.
     */
    private readonly string $databasePath;

    public function __construct()
    {
        parent::__construct();

        $this->databasePath = database_path('database.sqlite');
    }

    public function create(string $filename): string
    {
        if (! file_exists($this->databasePath)) {
            throw new DatabaseBackupException('SQLite database file does not exist.');
        }

        if (! copy($this->databasePath, sprintf('%s/%s', $this->backupDir, $filename))) {
            throw new DatabaseBackupException('Failed to create SQLite database backup.');
        }

        DatabaseDumpCreated::dispatch();

        return $filename;
    }

    public function restore(string $filename): void
    {
        if (! file_exists(sprintf('%s/%s', $this->backupDir, $filename))) {
            throw new DatabaseBackupException(sprintf('Backup file %s not found.', $filename));
        }

        if (! copy(sprintf('%s/%s', $this->backupDir, $filename), $this->databasePath)) {
            throw new DatabaseBackupException(sprintf('Failed to restore database from %s.', $filename));
        }
    }
}
