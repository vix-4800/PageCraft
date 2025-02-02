<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PromoCodeType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::random(8),
            'type' => $this->faker->randomElement(PromoCodeType::values()),
            'value' => $this->faker->randomFloat(2, 0, 100),
            'min_order_amount' => $this->faker->randomFloat(2, 0, 100),
            'usage_limit' => random_int(1, 10),
            'used_count' => 0,
            'valid_from' => $this->faker->dateTimeBetween(now()->subWeek(), now()),
            'valid_to' => $this->faker->dateTimeBetween(now()->addWeek(), now()->addMonth()),
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}
