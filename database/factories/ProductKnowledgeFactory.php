<?php

namespace Database\Factories;

use App\Models\ProductKnowledge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductKnowledge>
 */
class ProductKnowledgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url(),
            'order' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
        ];
    }
}
