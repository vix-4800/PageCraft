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
use Illuminate\Support\Facades\Storage;
use Str;
use Throwable;

class ProductService
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function storeProduct(array $productData): Product
    {
        try {
            DB::beginTransaction();

            $images = collect();
            if (isset($productData['product_images'])) {
                foreach ($productData['product_images'] as $index => $image) {
                    $images->push(Storage::disk('public')->put('products', $productData['product_images'][$index]));
                }
            }

            /** @var Product $product */
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'product_images' => $images->toArray(),
            ]);

            $this->addVariationsToProduct($product, collect($productData['variations']));

            DB::commit();

            return $product;
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
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

            $images = collect();
            if (isset($productData['product_images'])) {
                foreach ($productData['product_images'] as $index => $image) {
                    $images->push(Storage::disk('public')->put('products', $productData['product_images'][$index]));
                }
            }

            $product->update([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'product_images' => $images->toArray(),
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

    /**
     * Get statistics of reviews for a given product.
     *
     * @return array{
     *     count: int,
     *     average: float,
     *     stars: array{
     *         five_stars: int,
     *         four_stars: int,
     *         three_stars: int,
     *         two_stars: int,
     *         one_star: int
     *     }
     * }
     */
    public function getProductReviewsStatistics(int $productId): array
    {
        /** @var Product $product */
        $product = Product::with('reviews')->find($productId);

        return [
            'count' => $product->reviews->count(),
            'average' => $product->reviews->avg('rating'),
            'stars' => [
                'five_stars' => $product->reviews->where('rating', 5)->count(),
                'four_stars' => $product->reviews->where('rating', 4)->count(),
                'three_stars' => $product->reviews->where('rating', 3)->count(),
                'two_stars' => $product->reviews->where('rating', 2)->count(),
                'one_star' => $product->reviews->where('rating', 1)->count(),
            ],
        ];
    }
}
