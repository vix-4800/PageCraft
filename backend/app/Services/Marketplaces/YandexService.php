<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class YandexService extends MarketplaceService
{
    protected function createRequest(): PendingRequest
    {
        return Http::yandex($this->marketplaceAccount);
    }
}
