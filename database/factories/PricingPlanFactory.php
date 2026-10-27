<?php

namespace Database\Factories;

use App\Models\PricingPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PricingPlan>
 */
class PricingPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ['id' => fake()->word(), 'en' => fake()->word()],
            'tagline' => ['id' => fake()->words(2, true), 'en' => fake()->words(2, true)],
            'description' => ['id' => fake()->sentence(), 'en' => fake()->sentence()],
            'price' => fake()->randomFloat(2, 50, 5000),
            'currency' => fake()->randomElement(['IDR', 'USD']),
            'features' => [
                'id' => fake()->sentences(4),
                'en' => fake()->sentences(4),
            ],
            'cta_label' => ['id' => 'Pesan Sekarang', 'en' => 'Order Now'],
            'is_highlighted' => false,
            'is_published' => true,
            'sort_order' => 0,
        ];
    }
}
