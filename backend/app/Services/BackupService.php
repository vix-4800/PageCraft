<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DatabaseBackupException;
use App\Services\DatabaseBackup\DatabaseBackupService;
use Illuminate\Support\Collection;
use Str;

final readonly class BackupService
{
    private DatabaseBackupService $databaseBackupService;

    public function __construct()
    {
        $this->databaseBackupService = resolve(DatabaseBackupService::class);
    }

    /**
     * @throws DatabaseBackupException
     */
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

    /**
     * @throws DatabaseBackupException
     */
    public function restoreDatabaseBackup(string $backupFile): void
    {
        $backupFile .= str_ends_with($backupFile, '.sql') ? '' : '.sql';
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
