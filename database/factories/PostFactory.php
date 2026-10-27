<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleId = rtrim(fake()->unique()->sentence(3), '.');
        $titleEn = rtrim(fake()->unique()->sentence(3), '.');

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => ['id' => $titleId, 'en' => $titleEn],
            'slug' => ['id' => Str::slug($titleId), 'en' => Str::slug($titleEn)],
            'excerpt' => ['id' => fake()->sentence(), 'en' => fake()->sentence()],
            'body' => ['id' => fake()->paragraphs(5, true), 'en' => fake()->paragraphs(5, true)],
            'is_featured' => false,
            'published_at' => fake()->dateTimeBetween('-1 year', '-1 day'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => now()->addWeek(),
        ]);
    }

    /**
     * A post written only in the default locale.
     */
    public function indonesianOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => ['id' => $attributes['title']['id']],
            'slug' => ['id' => $attributes['slug']['id']],
            'excerpt' => ['id' => $attributes['excerpt']['id']],
            'body' => ['id' => $attributes['body']['id']],
        ]);
    }
}
