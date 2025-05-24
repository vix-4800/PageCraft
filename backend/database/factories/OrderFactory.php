<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
final class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = $this->faker->randomFloat(2, 0, 500);
        $tax = $this->faker->randomFloat(2, 0, 100);
        $shipping = $this->faker->randomFloat(2, 0, 100);
        $total = $subTotal + $tax + $shipping;

        return [
            'status' => $this->faker->randomElement(OrderStatus::cases()),
            'shipping' => $shipping,
            'tax' => $tax,
            'sub_total' => $subTotal,
            'total' => $total,
            'note' => $this->faker->sentences(2, true),
            'created_at' => $this->faker->dateTimeBetween(now()->subWeek(), now()),
        ];
    }

    /**
     * Set the order status.
     */
    public function withStatus(OrderStatus $status): static
    {
        return $this->state([
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the order has been delivered.
     */
    public function delivered(): static
    {
        return $this->withStatus(OrderStatus::DELIVERED);
    }

    /**
     * Indicate that the order has been cancelled.
     */
    public function canceled(): static
    {
        return $this->withStatus(OrderStatus::CANCELLED);
    }

    /**
     * Indicate that the order is being processed.
     */
    public function processing(): static
    {
        return $this->withStatus(OrderStatus::PROCESSING);
    }
}
