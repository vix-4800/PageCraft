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

    public function getOrders(array $params = []): array
    {
        return $this->makeRequest('GET', 'api/v3/orders/new', $params);
    }

    public function cancelOrder(string $orderId, ?string $reason = null): array
    {
        $data = [
            'orders' => [
                [
                    'orderId' => $orderId,
                    'reason' => $reason ?? 'Cancelled by seller',
                ],
            ],
        ];

        return $this->makeRequest('POST', 'api/v3/orders/reject', $data);
    }

    public function getOrderStatus(string $orderId): array
    {
        return $this->makeRequest('GET', 'api/v3/orders/status', ['orderId' => $orderId]);
    }

    public function acceptOrder(string $orderId): array
    {
        $data = [
            'orders' => [
                ['orderId' => $orderId],
            ],
        ];

        return $this->makeRequest('POST', 'api/v3/orders/accept', $data);
    }

    public function getStickers(array $orderIds, int $type = 1): array
    {
        $data = [
            'orders' => array_map(fn ($id): array => ['orderId' => $id], $orderIds),
            'type' => $type,
        ];

        return $this->makeRequest('POST', 'api/v3/orders/stickers', $data);
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
