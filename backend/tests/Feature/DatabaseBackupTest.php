<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\DatabaseDumpers\DatabaseDumper;
use Tests\TestCase;

class DatabaseBackupTest extends TestCase
{
    private DatabaseDumper $dumperService;

    private string $defaultBackupFilename = 'test_backup.sql';

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function test_backup_create_command(): void
    {
        resolve(DatabaseDumper::class)->create($this->defaultBackupFilename);

        $this->assertTrue(
            file_exists(config('backup.directory')."/{$this->defaultBackupFilename}")
        );
    }

    public function test_backup_clear_command(): void
    {
        // $this->dumperService->delete($this->defaultBackupFilename);

        // $this->assertTrue(
        //     ! file_exists(config('backup.directory')."/{$this->defaultBackupFilename}")
        // );
    }
}
