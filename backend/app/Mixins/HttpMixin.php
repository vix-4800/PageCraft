<?php

declare(strict_types=1);

namespace App\Mixins;

use App\Exceptions\TelegramException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/** @mixin Http */
class HttpMixin
{
    public function telegram(): callable
    {
        return function (): PendingRequest {
            $token = config('services.telegram.bot_token');

            throw_if(empty($token), new TelegramException('Telegram credentials are missing'));

            return Http::baseUrl("https://api.telegram.org/bot{$token}/");
        };
    }
}
