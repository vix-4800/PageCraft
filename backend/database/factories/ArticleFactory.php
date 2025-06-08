<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
final class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        $availableImages = Storage::disk('public')->allFiles('articles');

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'content' => $this->faker->text,
            'description' => $this->faker->text,
            'author' => $this->faker->name,
            'image' => $this->faker->randomElement($availableImages),
        ];
    }

    /**
     * Set the article status.
     */
    public function published(): static
    {
        return $this->state([
            'status' => ArticleStatus::PUBLISHED,
        ]);
    }

    /**
     * Set the article status.
     */
    public function archived(): static
    {
        return $this->state([
            'status' => ArticleStatus::ARCHIVED,
        ]);
    }
}
