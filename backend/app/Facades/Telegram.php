<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\TelegramService;
use Illuminate\Support\Facades\Facade;

class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramService::class;
    }
}
