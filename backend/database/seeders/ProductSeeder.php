<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

final class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::factory(5)->create()->each(function (ProductCategory $category): void {
            Product::factory(10)->for($category)->create()->each(function (Product $product): void {
                ProductVariation::factory(3)->for($product)->create()->each(function (ProductVariation $variation): void {
                    $attributeValues = ProductAttributeValue::inRandomOrder()
                        ->distinct()
                        ->take(2)
                        ->pluck('id')
                        ->map(fn ($id): array => ['product_attribute_value_id' => $id])
                        ->toArray();

                    $variation->productVariationAttributes()->createMany($attributeValues);
                });
            });
        });
    }
}
