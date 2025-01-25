<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
        try {
            if (! is_dir($this->backupPath)) {
                mkdir($this->backupPath, 0755, true);
            }

            $createdBackupFile = 'backup_'.date('Y_m_d_H_i_s').'_'.Str::random(8).'.sql';
            $filepath = "{$this->backupPath}/{$createdBackupFile}";

            $returnVar = Artisan::call('backup:create', [
                'filepath' => $filepath,
            ]);

            throw_if($returnVar !== Command::SUCCESS, new \Exception);

            return $createdBackupFile;
        } catch (\Exception) {
            throw new ApiException('Failed to create database backup.');
        }
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
