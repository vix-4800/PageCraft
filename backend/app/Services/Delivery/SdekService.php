<?php

declare(strict_types=1);

namespace App\Services\Delivery;

use App\Contracts\DeliveryService;
use App\Exceptions\Delivery\MethodNotAllowed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class SdekService implements DeliveryService
{
    protected string $baseUrl = 'https://api.sdek.ru';

    protected string $baseTestUrl = 'https://api.edu.cdek.ru';

    protected string $tokenCacheKey = 'sdek_token';

    public function __construct(
        private string $clientId,
        private string $clientSecret
    ) {
        //
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function makeRequest(string $url, string $method, array $data = []): array
    {
        throw_unless(in_array($method, ['GET', 'POST', 'PUT', 'DELETE']), new MethodNotAllowed);

        if (! Cache::has($this->tokenCacheKey)) {
            $this->renewAccessToken();
        }

        $request = Http::withToken($this->getAccessToken(), 'Bearer')->baseUrl($this->baseUrl);
        $request = match ($method) {
            'GET' => $request->withQueryParameters($data)->get($url),
            'POST' => $request->post($url, $data),
            'PUT' => $request->put($url, $data),
            'DELETE' => $request->delete($url),
        };

        return $request->throw()->json();
    }

    protected function renewAccessToken(): void
    {
        Cache::remember($this->tokenCacheKey, now()->addMinutes(60), function () {
            $result = Http::post("{$this->baseUrl}/v2/oauth/token?parameters", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ])->throw()->json();

            return $result['access_token'];
        });
    }

    protected function getAccessToken(): ?string
    {
        return Cache::get($this->tokenCacheKey);
    }

    public function createOrder(array $parameters): array
    {
        return $this->makeRequest('v2/orders', 'POST', $parameters);
    }

    public function getOrderInfo(string $orderUuid, array $parameters): array
    {
        return $this->makeRequest("v2/orders/{$orderUuid}", 'GET', $parameters);
    }

    public function cancelOrder(string $orderUuid, array $parameters): array
    {
        return $this->makeRequest("v2/orders/{$orderUuid}", 'DELETE', $parameters);
    }
}
