<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['prospect', 'hot_prospect', 'user']),
            'priority' => fake()->randomElement(['high', 'low', 'mid']),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
