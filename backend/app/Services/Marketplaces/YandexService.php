<?php

declare(strict_types=1);

namespace App\Services\Marketplaces;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class YandexService extends MarketplaceService
{
    /**
     * @link https://yandex.ru/dev/market/partner-api/doc/ru/reference/get-campaigns-id-offers
     */
    public function getProducts(array $params = []): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/offers', $campaignId);

        return $this->makeRequest('GET', $url, $params);
    }

    /**
     * @link https://yandex.ru/dev/market/partner-api/doc/ru/reference/put-campaigns-id-offers
     */
    public function createProduct(array $data): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/offers', $campaignId);

        return $this->makeRequest('PUT', $url, $data);
    }

    public function updateProduct(string $productId, array $data): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $data['offerId'] = $productId;
        $url = sprintf('campaigns/%s/offers', $campaignId);

        return $this->makeRequest('PUT', $url, $data);
    }

    public function deleteProduct(string $productId): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/offers/%s', $campaignId, $productId);

        return $this->makeRequest('DELETE', $url);
    }

    public function getOrders(array $params = []): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/orders', $campaignId);

        return $this->makeRequest('GET', $url, $params);
    }

    public function cancelOrder(string $orderId, ?string $reason = null): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/orders/%s/cancel', $campaignId, $orderId);
        $data = [
            'substatus' => $reason ?? 'USER_CHANGED_MIND',
        ];

        return $this->makeRequest('POST', $url, $data);
    }

    public function getOrderStatus(string $orderId): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $url = sprintf('campaigns/%s/orders/%s', $campaignId, $orderId);

        return $this->makeRequest('GET', $url);
    }

    public function acceptOrder(string $orderId): array
    {
        return [];
    }

    public function getStickers(array $orderIds, int $type = 1): array
    {
        $campaignId = $this->marketplaceAccount->settings()->firstWhere('key', 'campaign_id')->value ?? null;
        throw_unless($campaignId, new RuntimeException('Yandex Market campaign_id is missing'));

        $results = [];
        foreach ($orderIds as $orderId) {
            $url = sprintf('campaigns/%s/orders/%s/delivery/labels', $campaignId, $orderId);
            $results[$orderId] = $this->makeRequest('GET', $url, ['format' => $type === 2 ? 'PDF' : 'PNG']);
        }

        return $results;
    }

    protected function createRequest(): PendingRequest
    {
        return Http::yandex($this->marketplaceAccount)
            ->baseUrl('https://api.partner.market.yandex.ru/v2/')
            ->acceptJson();
    }
}
