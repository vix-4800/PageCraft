<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'product_images' => [
                "https://dummyimage.com/600x400/{$this->faker->hexColor()}/{$this->faker->hexColor()}.png&text={$name}",
                "https://dummyimage.com/600x400/{$this->faker->hexColor()}/{$this->faker->hexColor()}.png&text={$name}",
                "https://dummyimage.com/600x400/{$this->faker->hexColor()}/{$this->faker->hexColor()}.png&text={$name}",
            ],
        ];
    }
}
