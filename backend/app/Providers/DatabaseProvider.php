<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\DatabaseDumpers\DatabaseDumper;
use App\Services\DatabaseDumpers\MysqlDumper;
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
