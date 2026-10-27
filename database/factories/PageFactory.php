<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(1),
            'title' => ['id' => fake()->sentence(3), 'en' => fake()->sentence(3)],
            'content' => [
                'id' => ['heading' => fake()->sentence()],
                'en' => ['heading' => fake()->sentence()],
            ],
            'meta_title' => ['id' => fake()->sentence(4), 'en' => fake()->sentence(4)],
            'meta_description' => ['id' => fake()->sentence(12), 'en' => fake()->sentence(12)],
            'is_indexable' => true,
        ];
    }
}
