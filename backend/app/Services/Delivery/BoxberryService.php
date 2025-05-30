<?php

declare(strict_types=1);

namespace App\Services\Delivery;

use App\Contracts\DeliveryService;
use App\Exceptions\MethodNotAllowed;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final class BoxberryService implements DeliveryService
{
    private string $baseUrl = 'https://api.boxberry.ru/json.php';

    public function __construct(
        private readonly string $token
    ) {
        //
    }

    public function createOrder(array $parameters): array
    {
        return $this->makeRequest('v2/orders', 'POST', 'ParselCreate', $parameters);
    }

    public function getOrderInfo(string $orderUuid, array $parameters): array
    {
        // TODO
        return [];
    }

    public function cancelOrder(string $orderUuid, array $parameters): array
    {
        $parameters['sdata']['order_id'] = $orderUuid;

        return $this->createOrder($parameters);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws RequestException
     */
    private function makeRequest(string $url, string $method, string $serviceMethod, array $data): array
    {
        throw_unless(in_array($method, ['GET', 'POST']), new MethodNotAllowed);

        $request = Http::baseUrl($this->baseUrl);

        $requestData = array_merge([
            'token' => $this->token,
            'method' => $serviceMethod,
        ], $data);

        $request = match ($method) {
            'GET' => $request->withQueryParameters($requestData)->get($url),
            'POST' => $request->post($url, $requestData),
        };

        return $request->throw()->json();
    }

    private function getAccessToken(): string
    {
        return $this->token;
    }
}
