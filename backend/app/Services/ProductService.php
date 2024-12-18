<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Str;

class ProductService
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws ApiException
     */
    public function storeProduct(array $productData): Product
    {
        try {
            DB::beginTransaction();

            /** @var Product $product */
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'image' => $productData['image'] ?? null,
            ]);

            $this->addVariationsToProduct($product, collect($productData['variations']));

            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();

            // throw $th;
            throw new ApiException;
        }
    }

    /**
     * Update the specified product.
     *
     * @throws ApiException
     */
    public function updateProduct(array $productData, Product $product): Product
    {
        try {
            DB::beginTransaction();

            $product->update([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'image' => $productData['image'] ?? null,
            ]);

            $product->variations()->delete();

            $this->addVariationsToProduct($product, collect($productData['variations']));

            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();

            // throw $th;
            throw new ApiException;
        }
    }

    private function addVariationsToProduct(Product $product, Collection $variations): void
    {
        $variations->each(function (array $variation) use ($product): void {
            /** @var ProductVariation $createdVariation */
            $createdVariation = $product->variations()->create([
                'sku' => $variation['sku'],
                'price' => $variation['price'],
                'stock' => $variation['stock'],
                'image' => $variation['image'] ?? null,
            ]);

            $this->addAttributesToVariation($createdVariation, collect($variation['attributes']));
        });
    }

    private function addAttributesToVariation(ProductVariation $variation, Collection $attributes): void
    {
        $attributes->each(function (array $attribute) use ($variation): void {
            /** @var ProductAttribute $attributeFromDb */
            $attributeFromDb = ProductAttribute::firstOrCreate(['name' => $attribute['name']]);

            /** @var ProductAttributeValue $attributeValueFromDb */
            $attributeValueFromDb = $attributeFromDb->values()->firstOrCreate(['value' => $attribute['value']]);

            ProductVariationAttribute::insert([
                'product_variation_id' => $variation->id,
                'product_attribute_value_id' => $attributeValueFromDb->id,
            ]);
        });
    }
}
