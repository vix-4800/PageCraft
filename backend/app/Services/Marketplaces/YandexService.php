<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class YandexService extends MarketplaceService
{
    protected function createRequest(): PendingRequest
    {
        $key = $this->account->settings()->firstWhere('key', 'Api-Key')->value;

        return Http::withHeaders([
            'Api-Key' => $key,
        ]);
    }
}
