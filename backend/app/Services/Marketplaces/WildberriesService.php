<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class WildberriesService extends MarketplaceService
{
    /**
     * @link https://dev.wildberries.ru/en/docs/seller/api/public/api-v3/catalog/list
     */
    public function getProducts(array $params = []): array
    {
        return $this->makeRequest('GET', 'api/v3/catalog/list', $params);
    }

    /**
     * @link https://dev.wildberries.ru/en/docs/seller/api/public/api-v3/catalog/upload
     */
    public function createProduct(array $data): array
    {
        return $this->makeRequest('POST', 'api/v3/catalog/upload', $data);
    }

    /**
     * @link https://dev.wildberries.ru/en/docs/seller/api/public/api-v3/catalog/update
     */
    public function updateProduct(string $productId, array $data): array
    {
        $data['id'] = $productId;

        return $this->makeRequest('PATCH', 'api/v3/catalog/update', $data);
    }

    /**
     * @link https://dev.wildberries.ru/en/docs/seller/api/public/api-v3/catalog/delete
     */
    public function deleteProduct(string $productId): array
    {
        return $this->makeRequest('DELETE', 'api/v3/catalog/delete', ['id' => $productId]);
    }

    protected function createRequest(): PendingRequest
    {
        $token = $this->marketplaceAccount->settings()->firstWhere('key', 'token')->value ?? null;

        throw_unless($token, new RuntimeException('Wildberries API token is missing'));

        return Http::baseUrl('https://suppliers-api.wildberries.ru/')
            ->withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);
    }
}
