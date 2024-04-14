<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'count' => fake()->randomNumber(2),
            'price' => fake()->randomNumber(5),
            'status'=> fake()->randomElement([ProductStatus::Draft, ProductStatus::Published])
        ];
    }
}
