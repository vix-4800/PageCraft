<?php

declare(strict_types=1);

namespace App\Contracts;

interface DeliveryService
{
    /**
     * Create a new order in the delivery service.
     */
    public function createOrder(array $parameters): array;

    /**
     * Get order info from the delivery service.
     */
    public function getOrderInfo(string $orderId, array $parameters): array;

    /**
     * Cancel an order in the delivery service.
     */
    public function cancelOrder(string $orderId, array $parameters): array;
}
