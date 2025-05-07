<?php

declare(strict_types=1);

namespace App\Mixins;

use App\Exceptions\TelegramException;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/** @mixin Http */
final class HttpMixin
{
    public function telegram(): callable
    {
        return function (): PendingRequest {
            $token = config('services.telegram.bot_token');

            throw_if(empty($token), new TelegramException('Telegram credentials are missing'));

            return Http::baseUrl(sprintf('https://api.telegram.org/bot%s/', $token));
        };
    }

    public function ozon(): callable
    {
        return function (MarketplaceAccount $account): PendingRequest {
            $settings = $account->settings()
                ->where('key', 'in', ['client_id', 'api_key'])
                ->pluck('value', 'key')
                ->toArray();

            return Http::withHeaders([
                'Client-Id' => $settings['client_id'],
                'Api-Key' => $settings['api_key'],
            ]);
        };
    }

    public function wildberries(): callable
    {
        return fn (MarketplaceAccount $account): PendingRequest => Http::withToken(
            $account->settings()->firstWhere('key', 'token')->value
        );
    }

    public function yandex(): callable
    {
        return fn (MarketplaceAccount $account): PendingRequest => Http::withHeaders([
            'Api-Key' => $account->settings()->firstWhere('key', 'api_key')->value,
        ]);
    }

    public function github(): callable
    {
        return fn (): PendingRequest => Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
        ])->baseUrl(config('services.github.repo'));
    }
}
