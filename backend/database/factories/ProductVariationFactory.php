<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\GenerateSku;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sku = (new GenerateSku(ProductVariation::class))->handle();

        return [
            'sku' => $sku,
            'price' => $this->faker->numberBetween(50, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => "https://dummyimage.com/600x400/{$this->faker->hexColor()}/{$this->faker->hexColor()}.png&text={$sku}",
        ];
    }
}
