<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class OzonService extends MarketplaceService
{
    /**
     * @link https://docs.ozon.ru/api/seller/#operation/ProductAPI_GetProductList
     */
    public function getProducts(array $params = []): array
    {
        $url = 'v2/product/list';

        return $this->makeRequest('POST', $url, $params);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/ProductAPI_CreateProduct
     */
    public function createProduct(array $data): array
    {
        $url = 'v2/product/import';

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/ProductAPI_UpdateProduct
     */
    public function updateProduct(string $productId, array $data): array
    {
        $url = 'v1/product/update';
        $data['product_id'] = $productId;

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/ProductAPI_DeactivateProduct
     */
    public function deleteProduct(string $productId): array
    {
        $url = 'v1/product/archive';
        $data = [
            'product_id' => $productId,
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/OrderAPI_GetOrderList
     */
    public function getOrders(array $params = []): array
    {
        $url = 'v3/posting/fbs/list'; // Для FBS (Fulfillment by Seller)

        return $this->makeRequest('POST', $url, $params);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/OrderAPI_CancelPosting
     */
    public function cancelOrder(string $orderId, ?string $reason = null): array
    {
        $url = 'v1/posting/cancel';
        $data = [
            'posting_number' => $orderId,
            'cancel_reason_id' => $reason ?? 1,
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/OrderAPI_GetPostingByNumber
     */
    public function getOrderStatus(string $orderId): array
    {
        $url = 'v3/posting/fbs/get';
        $data = [
            'posting_number' => $orderId,
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/OrderAPI_ShipPosting
     */
    public function acceptOrder(string $orderId): array
    {
        $url = 'v1/posting/fbs/ship';
        $data = [
            'posting_number' => $orderId,
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    /**
     * @link https://docs.ozon.ru/api/seller/#operation/PostingAPI_GetSticker
     */
    public function getStickers(array $orderIds, int $type = 1): array
    {
        $url = 'v1/posting/fbs/sticker';

        $data = [
            'posting_number' => $orderIds,
            'file_type' => $type === 2 ? 'pdf' : 'png',
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    protected function createRequest(): PendingRequest
    {
        return Http::ozon($this->marketplaceAccount)
            ->baseUrl('https://api-seller.ozon.ru/')
            ->acceptJson();
    }
}
