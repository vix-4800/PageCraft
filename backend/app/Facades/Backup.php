<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\BackupService;
use Illuminate\Support\Facades\Facade;

class Backup extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BackupService::class;
    }
}
