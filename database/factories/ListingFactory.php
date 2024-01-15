<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(1, 4),
            'description' => fake()->sentence(10, 40),
            'user_id' => fake()->numberBetween(1, 2),
            'category_id' => fake()->numberBetween(1, 19),
            'town_id' => fake()->numberBetween(1, 48434),
            'is_hidden' => false,
        ];
    }
}
