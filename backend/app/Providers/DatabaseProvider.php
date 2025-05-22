<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\DatabaseBackup\DatabaseBackupService;
use App\Services\DatabaseBackup\MysqlBackupService;
use App\Services\DatabaseBackup\PostgresBackupService;
use App\Services\DatabaseBackup\SqliteBackupService;
use Exception;
use Illuminate\Support\ServiceProvider;

final class DatabaseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DatabaseBackupService::class, fn (): DatabaseBackupService => match (config('database.default')) {
            'mysql' => new MysqlBackupService,
            'pgsql' => new PostgresBackupService,
            'sqlite' => new SqliteBackupService,
            default => throw new Exception('Unknown database driver'),
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
