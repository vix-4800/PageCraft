<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAttributes();
        $this->createAttributeValues();
    }

    private function createAttributes(): void
    {
        $attributes = [
            'color',
            'size',
            'material',
        ];

        foreach ($attributes as $attribute) {
            ProductAttribute::create([
                'name' => $attribute,
            ]);
        }
    }

    private function createAttributeValues(): void
    {
        /** @var ProductAttribute $colorAttribute */
        $colorAttribute = ProductAttribute::firstWhere('name', 'color');
        $colorAttribute->values()->createMany([
            ['value' => 'red'],
            ['value' => 'blue'],
            ['value' => 'green'],
        ]);

        /** @var ProductAttribute $sizeAttribute */
        $sizeAttribute = ProductAttribute::firstWhere('name', 'size');
        $sizeAttribute->values()->createMany([
            ['value' => 'xs'],
            ['value' => 's'],
            ['value' => 'm'],
            ['value' => 'l'],
            ['value' => 'xl'],
        ]);

        /** @var ProductAttribute $materialAttribute */
        $materialAttribute = ProductAttribute::firstWhere('name', 'material');
        $materialAttribute->values()->createMany([
            ['value' => 'cotton'],
            ['value' => 'leather'],
            ['value' => 'polyester'],
        ]);
    }
}
