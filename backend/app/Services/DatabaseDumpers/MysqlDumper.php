<?php

declare(strict_types=1);

namespace App\Services\DatabaseDumpers;

use App\Exceptions\DatabaseBackupException;
use App\Helpers\DatabaseBackup;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class MysqlDumper extends DatabaseDumper
{
    public function create(): void
    {
        throw_unless(Artisan::call('backup:create') == Command::SUCCESS, new DatabaseBackupException('Failed to create database backup.'));
    }

    public function list(): Collection
    {
        if (! is_dir($this->backupDir)) {
            return [];
        }

        $backups = collect();
        $files = scandir($this->backupDir);
        $files = array_filter($files, fn ($file): bool => pathinfo($file, PATHINFO_EXTENSION) === 'sql');

        foreach ($files as $file) {
            $backups->push((new DatabaseBackup("{$this->backupDir}/{$file}"))->toArray());
        }

        return $backups;
    }

    public function delete(string $file): void
    {
        unlink("{$this->backupDir}/{$file}");
    }

    public function deleteAll(): void
    {
        /** @var array $file */
        foreach ($this->list() as $file) {
            $this->delete($file['name']);
        }
    }
}
