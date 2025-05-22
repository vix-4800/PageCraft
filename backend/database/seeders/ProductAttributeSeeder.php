<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

final class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = collect(['color', 'size', 'material']);

        $colors = collect(['red', 'green', 'blue']);
        $sizes = collect(['xs', 's', 'm', 'l', 'xl']);
        $materials = collect(['leather', 'fabric', 'polyester']);

        $attributes->each(function (string $attribute) use ($colors, $sizes, $materials): void {
            $attribute = ProductAttribute::create([
                'name' => $attribute,
            ]);

            switch ($attribute->name) {
                case 'color':
                    $attribute->values()->createMany(
                        $colors->map(fn (string $color): array => ['value' => $color])->toArray()
                    );
                    break;
                case 'size':
                    $attribute->values()->createMany(
                        $sizes->map(fn (string $size): array => ['value' => $size])->toArray()
                    );
                    break;
                case 'material':
                    $attribute->values()->createMany(
                        $materials->map(fn (string $material): array => ['value' => $material])->toArray()
                    );
                    break;
            }
        });
    }
}
