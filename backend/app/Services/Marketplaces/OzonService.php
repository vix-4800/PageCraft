<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class OzonService extends MarketplaceService
{
    protected function createRequest(): PendingRequest
    {
        return Http::ozon($this->account);
    }
}
