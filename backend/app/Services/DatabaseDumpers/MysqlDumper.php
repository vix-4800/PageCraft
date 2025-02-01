<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Exceptions\DatabaseBackupException;

class MysqlDumper extends DatabaseDumper
{
    public function create(string $filename): void
    {
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg(config('database.connections.mysql.username')),
            escapeshellarg(config('database.connections.mysql.password')),
            escapeshellarg(config('database.connections.mysql.host')),
            escapeshellarg(config('database.connections.mysql.database')),
            escapeshellarg("{$this->backupDir}/{$filename}")
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException('Failed to create database backup.'));
    }

    public function restore(string $filename): void
    {
        $filePath = "{$this->backupDir}/{$filename}";

        throw_unless(is_file($filePath), new DatabaseBackupException("Backup file {$filename} not found."));

        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            escapeshellarg(config('database.connections.mysql.username')),
            escapeshellarg(config('database.connections.mysql.password')),
            escapeshellarg(config('database.connections.mysql.host')),
            escapeshellarg(config('database.connections.mysql.database')),
            escapeshellarg($filePath)
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException("Failed to restore database from {$filename}."));
    }
}
