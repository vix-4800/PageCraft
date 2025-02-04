<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Events\DatabaseDumpCreated;
use App\Exceptions\DatabaseBackupException;

class SqliteDumper extends DatabaseDumper
{
    /**
     * The path to the SQLite database file.
     */
    protected string $databasePath;

    public function __construct()
    {
        parent::__construct();

        $this->databasePath = database_path('database.sqlite');
    }

    public function create(string $filename): void
    {
        if (! file_exists($this->databasePath)) {
            throw new DatabaseBackupException('SQLite database file does not exist.');
        }

        if (! copy($this->databasePath, "{$this->backupDir}/{$filename}")) {
            throw new DatabaseBackupException('Failed to create SQLite database backup.');
        }

        DatabaseDumpCreated::dispatch();
    }

    public function restore(string $filename): void
    {
        if (! file_exists("{$this->backupDir}/{$filename}")) {
            throw new DatabaseBackupException("Backup file {$filename} not found.");
        }

        if (! copy("{$this->backupDir}/{$filename}", $this->databasePath)) {
            throw new DatabaseBackupException("Failed to restore database from {$filename}.");
        }
    }
}
