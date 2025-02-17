<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use App\Exceptions\MethodNotAllowed;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Client\PendingRequest;

abstract class MarketplaceService
{
    public function __construct(
        protected readonly MarketplaceAccount $account
    ) {
        //
    }

    /**
     * @param  string  $method  Request method (GET, POST, PUT, PATCH, DELETE)
     * @param  string  $url  Request URL
     * @param  array<string, mixed>  $data  Request data (optional) - query or body parameters
     * @return array<string, mixed>
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function makeRequest(string $method, string $url, array $data = []): array
    {
        throw_unless(in_array($method, ['GET', 'POST', 'PATCH', 'DELETE']), new MethodNotAllowed);

        $request = $this->createRequest();

        $request = match ($method) {
            'GET' => $request->withQueryParameters($data)->get($url),
            'POST' => $request->post($url, $data),
            'PATCH' => $request->patch($url, $data),
            'DELETE' => $request->delete($url),
        };

        return $request->throw()->json();
    }

    abstract protected function createRequest(): PendingRequest;
}
