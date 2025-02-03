<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Events\DatabaseDumpCreated;
use App\Exceptions\DatabaseBackupException;

class PostgresDumper extends DatabaseDumper
{
    public function create(string $filename): void
    {
        $command = sprintf(
            'pg_dump --username=%s --host=%s --no-password --format=custom --file=%s %s',
            escapeshellarg($this->databaseUsername),
            escapeshellarg($this->databaseHost),
            escapeshellarg("{$this->backupDir}/{$filename}"),
            escapeshellarg($this->databaseName)
        );

        $returnVar = null;
        exec($command, $output, $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException('Failed to create database backup: '.implode("\n", $output)));

        DatabaseDumpCreated::dispatch();
    }

    public function restore(string $filename): void
    {
        $filePath = "{$this->backupDir}/{$filename}";

        throw_unless(file_exists($filePath), new DatabaseBackupException("Backup file {$filename} not found."));

        $command = sprintf(
            'pg_restore --username=%s --host=%s --no-password --clean --dbname=%s %s',
            escapeshellarg($this->databaseUsername),
            escapeshellarg($this->databaseHost),
            escapeshellarg($this->databaseName),
            escapeshellarg($filePath)
        );

        $returnVar = null;
        exec($command, $output, $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException("Failed to restore database from {$filename}: ".implode("\n", $output)));
    }
}
