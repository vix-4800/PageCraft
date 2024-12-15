<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\GenerateSku;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var ProductAttribute $sizeAttribute */
        $sizeAttribute = ProductAttribute::where('name', 'size')->with('values')->first();

        /** @var ProductAttribute $colorAttribute */
        $colorAttribute = ProductAttribute::where('name', 'color')->with('values')->first();

        /** @var ProductAttribute $materialAttribute */
        $materialAttribute = ProductAttribute::where('name', 'material')->with('values')->first();

        $productsData = [
            [
                'name' => 'T-Shirt',
                'description' => 'A basic T-Shirt made from 100% cotton, offering a comfortable fit and available in various colors and sizes.',
                'image' => 'https://d2devwt40at1e2.cloudfront.net/api/file/qtLzdrc2TrmjLULaAZyE',
                'variations' => [
                    [
                        'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                        'price' => random_int(1000, 2500),
                        'stock' => random_int(0, 100),
                        'image' => 'http://clipart-library.com/newhp/Red_T_Shirt_PNG_Clip_Art-3105.png',
                        'attributes' => [
                            ['product_attribute_value_id' => ProductAttributeValue::firstWhere('value', 'm')->id],
                            ['product_attribute_value_id' => $colorAttribute->values()->firstOrCreate(['value' => 'red'])->id],
                        ],
                    ],
                    [
                        'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                        'price' => random_int(1000, 2500),
                        'stock' => random_int(0, 100),
                        'image' => 'https://static.vecteezy.com/system/resources/previews/008/533/235/original/black-t-shirt-mockup-cutout-file-png.png',
                        'attributes' => [
                            ['product_attribute_value_id' => $sizeAttribute->values()->firstWhere('value', 'l')->id],
                            ['product_attribute_value_id' => $colorAttribute->values()->firstOrCreate(['value' => 'black'])->id],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Hoodie',
                'description' => 'A comfortable hoodie made from 100% cotton, offering a relaxed fit and available in various colors and sizes.',
                'image' => 'https://s3-eu-west-1.amazonaws.com/images.linnlive.com/4026ef0cc7c4844b9d335306aa30fe5c/10518fb3-0456-4c38-96f3-cface3d52092.jpg',
                'variations' => [
                    [
                        'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                        'price' => random_int(1000, 2500),
                        'stock' => random_int(0, 100),
                        'image' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fpbmo.files.wordpress.com%2F2012%2F01%2Fhoodie.jpg&f=1&nofb=1&ipt=aa4a24f402aa13c2ee29a35e2ec73c950edfe9eb5841da34391eb6de065ded99&ipo=images',
                        'attributes' => [
                            ['product_attribute_value_id' => $sizeAttribute->values()->firstWhere('value', 'm')->id],
                            ['product_attribute_value_id' => $colorAttribute->values()->firstOrCreate(['value' => 'white'])->id],
                            ['product_attribute_value_id' => $materialAttribute->values()->firstOrCreate(['value' => 'cotton'])->id],
                        ],
                    ],
                    [
                        'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                        'price' => random_int(1000, 2500),
                        'stock' => random_int(0, 100),
                        'image' => 'https://i5.walmartimages.com/asr/3a043039-85a5-4510-b6ff-f7521d8705bf_1.090f41bdf20ceb990ac16daa8d626417.jpeg',
                        'attributes' => [
                            ['product_attribute_value_id' => $sizeAttribute->values()->firstWhere('value', 'l')->id],
                            ['product_attribute_value_id' => $colorAttribute->values()->firstOrCreate(['value' => 'black'])->id],
                            ['product_attribute_value_id' => $materialAttribute->values()->firstOrCreate(['value' => 'polyester'])->id],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Cap',
                'description' => 'A stylish cap that provides excellent sun protection and adds a fashionable touch to any outfit, available in multiple colors and adjustable for a perfect fit.',
                'image' => 'https://az1.hatstoremedia.com/hatstore/images/5711176162069_1/0/0/0/wolf-baseball-cap-navy-blue-adjustable-state-of-wow.jpg',
                'variations' => [
                    [
                        'sku' => (new GenerateSku(ProductVariation::class))->handle(),
                        'price' => random_int(1000, 2500),
                        'stock' => random_int(0, 100),
                        'image' => 'https://www.bmcsports.ie/images/new-era-new-york-yankees-league-basic-9forty-cap-red-p30998-74703_image.jpg',
                        'attributes' => [
                            ['product_attribute_value_id' => $sizeAttribute->values()->firstWhere('value', 's')->id],
                            ['product_attribute_value_id' => $colorAttribute->values()->firstOrCreate(['value' => 'red'])->id],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($productsData as $productData) {
            $product = $this->createProduct($productData);

            $variations = $this->createProductVariations($product, collect($productData['variations']));

            $variations->each(function (ProductVariation $variation, int $index) use ($productData): void {
                $this->createVariationAttributes($variation, $productData['variations'][$index]['attributes']);
            });
        }
    }

    private function createProduct(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'image' => $data['image'],
            'description' => $data['description'],
        ]);
    }

    /**
     * @return Collection<int, ProductVariation>
     */
    private function createProductVariations(Product $product, Collection $variations): Collection
    {
        return $product->variations()->createMany($variations->map(fn (array $variation): array => [
            'sku' => $variation['sku'],
            'price' => $variation['price'],
            'stock' => $variation['stock'],
            'image' => $variation['image'],
        ])->toArray());
    }

    /**
     * @return Collection<int, ProductVariationAttribute>
     */
    private function createVariationAttributes(ProductVariation $variation, array $attributes): Collection
    {
        return $variation->productVariationAttributes()->createMany($attributes);
    }
}
