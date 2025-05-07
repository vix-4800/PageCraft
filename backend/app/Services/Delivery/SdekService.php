<?php

declare(strict_types=1);

namespace App\Services\Delivery;

use App\Contracts\DeliveryService;
use App\Exceptions\MethodNotAllowed;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class SdekService implements DeliveryService
{
    private string $baseUrl = 'https://api.sdek.ru';

    private string $baseTestUrl = 'https://api.edu.cdek.ru';

    private string $tokenCacheKey = 'sdek_token';

    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret
    ) {
        //
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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws RequestException
     */
    private function makeRequest(string $url, string $method, array $data = []): array
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

    private function renewAccessToken(): void
    {
        Cache::remember($this->tokenCacheKey, now()->addMinutes(60), function (): string {
            $result = Http::post("{$this->baseUrl}/v2/oauth/token?parameters", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ])->throw()->json();

            return $result['access_token'];
        });
    }

    private function getAccessToken(): ?string
    {
        return Cache::get($this->tokenCacheKey);
    }
}
