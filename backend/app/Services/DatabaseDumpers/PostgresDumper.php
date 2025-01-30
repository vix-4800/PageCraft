<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Exceptions\DatabaseBackupException;

class PostgresDumper extends DatabaseDumper
{
    public function create(string $filename): void
    {
        $command = sprintf(
            'pg_dump --username=%s --host=%s --no-password --format=custom --file=%s %s',
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg("{$this->backupDir}/{$filename}"),
            escapeshellarg(env('DB_DATABASE'))
        );

        $returnVar = null;
        exec($command, $output, $returnVar);

        throw_unless($returnVar === 0, new DatabaseBackupException('Failed to create database backup: '.implode("\n", $output)));
    }
}
