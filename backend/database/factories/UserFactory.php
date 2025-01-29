<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'password' => static::$password ??= bcrypt('password'),
            'remember_token' => Str::random(10),
            'role_id' => Role::firstWhere('name', UserRole::CUSTOMER)->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state([
            'role_id' => Role::firstWhere('name', UserRole::ADMIN)->id,
        ]);
    }
}
