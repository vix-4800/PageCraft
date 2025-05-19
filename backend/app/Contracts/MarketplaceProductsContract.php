<?php

declare(strict_types=1);

namespace App\Contracts;

use RuntimeException;

interface MarketplaceProductsContract
{
    /**
     * Retrieves a list of products based on the given parameters.
     *
     * @param  array  $params  Optional query parameters for filtering, sorting, etc
     * @return array Returns an array of products matching the criteria
     */
    public function getProducts(array $params = []): array;

    /**
     * Creates a new product in the marketplace.
     *
     * @param  array  $data  Product data including required fields.
     * @return array Returns the created product data with additional system fields.
     *
     * @throws RuntimeException If product creation fails.
     */
    public function createProduct(array $data): array;

    /**
     * Updates an existing product in the marketplace.
     *
     * @param  string  $productId  The ID of the product to update.
     * @param  array  $data  The product data to update.
     * @return array Returns the updated product data.
     *
     * @throws RuntimeException If product update fails or product not found.
     */
    public function updateProduct(string $productId, array $data): array;

    /**
     * Deletes a product from the marketplace.
     *
     * @param  string  $productId  The ID of the product to delete.
     * @return array Returns confirmation of deletion.
     *
     * @throws RuntimeException If product deletion fails or product not found.
     */
    public function deleteProduct(string $productId): array;
}
