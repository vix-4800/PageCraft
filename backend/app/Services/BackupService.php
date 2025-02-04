<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\DatabaseBackup\DatabaseBackupService;
use Illuminate\Support\Collection;
use Str;

class BackupService
{
    protected DatabaseBackupService $databaseBackupService;

    public function __construct()
    {
        $this->databaseBackupService = resolve(DatabaseBackupService::class);
    }

    public function createDatabaseBackup(?string $filename = null): string
    {
        $filename ??= 'backup_'.date('Y_m_d_H_i_s').'_'.Str::random(8);
        $filename .= str_ends_with($filename, '.sql') ? '' : '.sql';

        return $this->databaseBackupService->create($filename);
    }

    public function listDatabaseBackups(): Collection
    {
        return $this->databaseBackupService->list();
    }

    public function restoreDatabaseBackup(string $backupFile): void
    {
        $this->databaseBackupService->restore($backupFile);
    }

    public function deleteDatabaseBackup(string $backupFile): void
    {
        $this->databaseBackupService->delete($backupFile);
    }

    public function deleteAllDatabaseBackups(): void
    {
        $this->databaseBackupService->deleteAll();
    }
}
