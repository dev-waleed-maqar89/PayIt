<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $q = rand(1, 12);
        return [
            'name' => $this->faker->text(36),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'image' => $this->faker->imageUrl(480, 480),
            'quantity' => $q
        ];
    }
}