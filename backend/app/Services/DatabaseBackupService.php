<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use Str;

class DatabaseBackupService
{
    private string $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
    }

    public function create(): string
    {
        if (! is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }

        $createdBackupFile = 'backup_'.date('Y_m_d_H_i_s').'_'.Str::random(8).'.sql';
        $filePath = "{$this->backupPath}/{$createdBackupFile}";

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($filePath)
        );

        $returnVar = null;
        exec($command, result_code: $returnVar);
        throw_if($returnVar !== 0, new ApiException('Failed to create database backup.'));

        return $createdBackupFile;
    }

    public function list(): array
    {
        if (! is_dir($this->backupPath)) {
            return [];
        }

        $backupFiles = scandir($this->backupPath);

        return array_filter($backupFiles, function ($file): bool {
            return pathinfo($file, PATHINFO_EXTENSION) === 'sql';
        });
    }

    public function delete(string $file): void
    {
        unlink("{$this->backupPath}/{$file}");
    }

    public function deleteAll(): void
    {
        foreach ($this->list() as $file) {
            $this->delete($file);
        }
    }
}
