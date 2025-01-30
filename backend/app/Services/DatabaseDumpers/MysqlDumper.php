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
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg("{$this->backupDir}/{$filename}")
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException('Failed to create database backup.'));
    }
}
