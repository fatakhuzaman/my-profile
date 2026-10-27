<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => fake()->name(),
            'author_title' => ['id' => fake()->jobTitle(), 'en' => fake()->jobTitle()],
            'company' => fake()->company(),
            'quote' => ['id' => fake()->paragraph(), 'en' => fake()->paragraph()],
            'rating' => 5,
            'is_published' => true,
            'sort_order' => 0,
        ];
    }
}
