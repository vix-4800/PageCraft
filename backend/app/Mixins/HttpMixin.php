<?php

declare(strict_types=1);

namespace App\Mixins;

use App\Exceptions\TelegramException;
use App\Models\MarketplaceAccount;
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

    public function ozon(): callable
    {
        return function (MarketplaceAccount $account): PendingRequest {
            $settings = $account->settings()
                ->where('key', 'in', ['Client-Id', 'Api-Key'])
                ->pluck('value', 'key')
                ->toArray();

            return Http::withHeaders([
                'Client-Id' => $settings['Client-Id'],
                'Api-Key' => $settings['Api-Key'],
            ]);
        };
    }

    public function wildberries(): callable
    {
        return function (MarketplaceAccount $account): PendingRequest {
            return Http::withToken(
                $account->settings()->firstWhere('key', 'token')->value
            );
        };
    }

    public function yandex(): callable
    {
        return function (MarketplaceAccount $account): PendingRequest {
            return Http::withHeaders([
                'Api-Key' => $account->settings()->firstWhere('key', 'Api-Key')->value,
            ]);
        };
    }

    public function github(): callable
    {
        return function (): PendingRequest {
            return Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
            ])->baseUrl(config('services.github.repo'));
        };
    }
}
