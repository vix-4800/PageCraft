<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Facades\Backup;
use Tests\TestCase;

final class DatabaseBackupTest extends TestCase
{
    private string $defaultBackupFilename = 'test_backup.sql';

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function test_backup_create_command(): void
    {
        Backup::createDatabaseBackup($this->defaultBackupFilename);

        $this->assertTrue(
            file_exists(config('backup.directory').('/'.$this->defaultBackupFilename))
        );
    }

    public function test_backup_clear_command(): void
    {
        // Backup::deleteDatabaseBackup($this->defaultBackupFilename);

        // $this->assertTrue(
        //     ! file_exists(config('backup.directory')."/{$this->defaultBackupFilename}")
        // );
    }
}
