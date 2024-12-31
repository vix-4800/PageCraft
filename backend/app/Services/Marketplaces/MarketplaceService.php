<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use App\Models\MarketplaceAccount;
use Illuminate\Http\Client\PendingRequest;

abstract class MarketplaceService
{
    public function __construct(
        protected readonly MarketplaceAccount $account
    ) {
        //
    }

    abstract protected function createRequest(): PendingRequest;
}
