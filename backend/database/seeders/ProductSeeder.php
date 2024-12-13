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
        $products = [
            [
                'name' => 'T-Shirt',
                'description' => 'A basic T-Shirt made from 100% cotton, offering a comfortable fit and available in various colors and sizes.',
                'image' => 'https://d2devwt40at1e2.cloudfront.net/api/file/qtLzdrc2TrmjLULaAZyE',
            ],
            [
                'name' => 'Hoodie',
                'description' => 'A comfortable hoodie made from 100% cotton, offering a relaxed fit and available in various colors and sizes.',
                'image' => 'https://s3-eu-west-1.amazonaws.com/images.linnlive.com/4026ef0cc7c4844b9d335306aa30fe5c/10518fb3-0456-4c38-96f3-cface3d52092.jpg',
            ],
            [
                'name' => 'Cap',
                'description' => 'A stylish cap that provides excellent sun protection and adds a fashionable touch to any outfit, available in multiple colors and adjustable for a perfect fit.',
                'image' => 'https://az1.hatstoremedia.com/hatstore/images/5711176162069_1/0/0/0/wolf-baseball-cap-navy-blue-adjustable-state-of-wow.jpg',
            ],
        ];

        foreach ($products as $productData) {
            /** @var Product $product */
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'image' => $productData['image'],
                'description' => $productData['description'],
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
}
