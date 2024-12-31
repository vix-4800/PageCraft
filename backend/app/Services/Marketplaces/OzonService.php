<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class OzonService extends MarketplaceService
{
    protected function createRequest(): PendingRequest
    {
        $settings = $this->account->settings()
            ->where('key', 'in', ['Client-Id', 'Api-Key'])
            ->pluck('value', 'key')
            ->toArray();

        return Http::withHeaders([
            'Client-Id' => $settings['Client-Id'],
            'Api-Key' => $settings['Api-Key'],
        ]);
    }
}
