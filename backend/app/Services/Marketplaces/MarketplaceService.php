<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use App\Contracts\MarketplaceOrdersContract;
use App\Contracts\MarketplaceProductsContract;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use InvalidArgumentException;

abstract class MarketplaceService implements MarketplaceOrdersContract, MarketplaceProductsContract
{
    public function __construct(
        protected readonly MarketplaceAccount $marketplaceAccount
    ) {
        //
    }

    abstract protected function createRequest(): PendingRequest;

    /**
     * @param  string  $method  Request method (GET, POST, PUT, PATCH, DELETE)
     * @param  string  $url  Request URL
     * @param  array<string, mixed>  $data  Request data (optional) - query or body parameters
     * @return array<string, mixed>
     *
     * @throws RequestException
     */
    protected function makeRequest(string $method, string $url, array $data = []): array
    {
        throw_unless(
            in_array($method, ['GET', 'POST', 'PATCH', 'PUT', 'DELETE']),
            new InvalidArgumentException('Method not allowed: '.$method)
        );

        $request = $this->createRequest();

        $response = match ($method) {
            'GET' => $request->withQueryParameters($data)->get($url),
            'POST' => $request->post($url, $data),
            'PATCH' => $request->patch($url, $data),
            'PUT' => $request->put($url, $data),
            'DELETE' => $request->delete($url, $data),
        };

        return $response->throw()->json();
    }
}
