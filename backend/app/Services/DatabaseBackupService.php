<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupService
{
    private string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
    }

    public function create(): Response
    {
        try {
            if (! is_dir($this->backupDir)) {
                mkdir($this->backupDir, 0755, true);
            }

            throw_unless(Artisan::call('backup:create') == Command::SUCCESS, new \Exception);

            return ApiResponse::empty();
        } catch (\Exception) {
            throw new ApiException('Failed to create database backup.');
        }
    }

    public function list(): array
    {
        if (! is_dir($this->backupDir)) {
            return [];
        }

        $backupFiles = scandir($this->backupDir);

        return array_filter($backupFiles, function ($file): bool {
            return pathinfo($file, PATHINFO_EXTENSION) === 'sql';
        });
    }

    public function delete(string $file): void
    {
        unlink("{$this->backupDir}/{$file}");
    }

    public function deleteAll(): void
    {
        foreach ($this->list() as $file) {
            $this->delete($file);
        }
    }

    /**
     * Get the backup directory path.
     */
    public function getBackupDirectory(): string
    {
        return $this->backupDir;
    }
}
