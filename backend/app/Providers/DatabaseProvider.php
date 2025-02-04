<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\DatabaseDumpers\DatabaseDumper;
use App\Services\DatabaseDumpers\MysqlDumper;
use App\Services\DatabaseDumpers\PostgresDumper;
use App\Services\DatabaseDumpers\SqliteDumper;
use Illuminate\Support\ServiceProvider;

class DatabaseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DatabaseDumper::class, fn (): DatabaseDumper => match (config('database.default')) {
            'mysql' => new MysqlDumper,
            'pgsql' => new PostgresDumper,
            'sqlite' => new SqliteDumper,
            default => throw new \Exception('Unknown database driver'),
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
