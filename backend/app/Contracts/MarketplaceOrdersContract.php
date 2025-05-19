<?php

declare(strict_types=1);

namespace App\Contracts;

use RuntimeException;

interface MarketplaceOrdersContract
{
    /**
     * Retrieves a list of orders based on filtering parameters.
     *
     * @param  array  $params  Filtering and pagination parameters
     * @return array List of orders with their details
     *
     * @throws RuntimeException If order retrieval fails
     */
    public function getOrders(array $params = []): array;

    /**
     * Cancels a specific order with optional cancellation reason.
     *
     * @param  string  $orderId  Unique identifier of the order
     * @param  string|null  $reason  Optional cancellation reason
     * @return array Operation status and cancellation details
     *
     * @throws RuntimeException If cancellation fails or order not found
     */
    public function cancelOrder(string $orderId, ?string $reason = null): array;

    /**
     * Retrieves current status of a specific order.
     *
     * @param  string  $orderId  Unique identifier of the order
     * @return array Current order status information
     *
     * @throws RuntimeException If status retrieval fails or order not found
     */
    public function getOrderStatus(string $orderId): array;

    /**
     * Accepts/confirms an order for processing.
     *
     * @param  string  $orderId  Unique identifier of the order
     * @return array Operation status and acceptance details
     *
     * @throws RuntimeException If order acceptance fails or order not found
     */
    public function acceptOrder(string $orderId): array;

    /**
     * Generates stickers for specified orders.
     *
     * @param  array  $orderIds  Array of order identifiers
     * @param  int  $type  Type of stickers to generate (default = 1)
     * @return array Generated stickers data or download information
     *
     * @throws RuntimeException If sticker generation fails
     */
    public function getStickers(array $orderIds, int $type = 1): array;
}
