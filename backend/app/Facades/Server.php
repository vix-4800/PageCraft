<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\ServerService;
use Illuminate\Support\Facades\Facade;

class Server extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ServerService::class;
    }
}
