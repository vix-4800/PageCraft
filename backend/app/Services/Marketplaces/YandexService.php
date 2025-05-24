<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class YandexService extends MarketplaceService
{
    public function getOrders(array $params = []): array
    {
        return [];
    }

    public function cancelOrder(string $orderId, ?string $reason = null): array
    {
        return [];
    }

    public function getOrderStatus(string $orderId): array
    {
        return [];
    }

    public function acceptOrder(string $orderId): array
    {
        return [];
    }

    public function getStickers(array $orderIds, int $type = 1): array
    {
        return [];
    }

    public function getProducts(array $params = []): array
    {
        return [];
    }

    public function createProduct(array $data): array
    {
        return [];
    }

    public function updateProduct(string $productId, array $data): array
    {
        return [];
    }

    public function deleteProduct(string $productId): array
    {
        return [];
    }

    protected function createRequest(): PendingRequest
    {
        return Http::yandex($this->marketplaceAccount);
    }
}
