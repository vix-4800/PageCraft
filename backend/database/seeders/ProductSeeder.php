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
            'image' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.etsystatic.com%2F18117093%2Fr%2Fil%2Fc13d1b%2F3096741212%2Fil_fullxfull.3096741212_pl8x.jpg&f=1&nofb=1&ipt=3062431b8bc48e02e1999c98d41dd79cf50065da467c3c040209a0e641d22a6e&ipo=images',
            'description' => 'A basic T-Shirt',
        ]);

        $variations = $product->variations()->createMany([
            [
                'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                'price' => random_int(1000, 2500),
                'stock' => random_int(0, 100),
            ],
            [
                'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                'price' => random_int(1000, 2500),
                'stock' => random_int(0, 100),
            ],
            [
                'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                'price' => random_int(1000, 2500),
                'stock' => random_int(0, 100),
            ],
        ]);

        $variations->each(function (ProductVariation $variation): void {
            $variation->productVariationAttributes()->createMany([
                ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'red')->id],
                ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'm')->id],
                ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'cotton')->id],
            ]);
        });
    }
}
