<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\GenerateSku;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;
use Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Product $product */
        $product = Product::create([
            'name' => 'T-Shirt',
            'slug' => Str::slug('T-Shirt'),
            'description' => 'A basic T-Shirt',
        ]);

        /** @var ProductVariation $variation */
        $variation = $product->variations()->create([
            'sku' => (new GenerateSku(ProductVariation::class))->handle(),
            'price' => random_int(1000, 2500),
            'stock' => random_int(0, 100),
        ]);

        $variation->productVariationAttributes()->createMany([
            ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'red')->id],
            ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'm')->id],
            ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'cotton')->id],
        ]);
    }
}
