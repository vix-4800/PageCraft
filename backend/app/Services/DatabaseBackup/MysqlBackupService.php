<?php

declare(strict_types=1);

namespace App\Services\DatabaseBackup;

use App\Events\DatabaseDumpCreated;
use App\Exceptions\DatabaseBackupException;

final class MysqlBackupService extends DatabaseBackupService
{
    public function create(string $filename): string
    {
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($this->databaseUsername),
            escapeshellarg($this->databasePassword),
            escapeshellarg($this->databaseHost),
            escapeshellarg($this->databaseName),
            escapeshellarg(sprintf('%s/%s', $this->backupDir, $filename))
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException('Failed to create database backup.'));

        DatabaseDumpCreated::dispatch();

        return $filename;
    }

    public function restore(string $filename): void
    {
        $filePath = sprintf('%s/%s', $this->backupDir, $filename);

        throw_unless(is_file($filePath), new DatabaseBackupException(sprintf('Backup file %s not found.', $filename)));

        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            escapeshellarg($this->databaseUsername),
            escapeshellarg($this->databasePassword),
            escapeshellarg($this->databaseHost),
            escapeshellarg($this->databaseName),
            escapeshellarg($filePath)
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException(sprintf('Failed to restore database from %s.', $filename)));
    }
}
