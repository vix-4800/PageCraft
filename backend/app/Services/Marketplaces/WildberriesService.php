<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class WildberriesService extends MarketplaceService
{
    protected function createRequest(): PendingRequest
    {
        return Http::wildberries($this->marketplaceAccount);
    }
}
