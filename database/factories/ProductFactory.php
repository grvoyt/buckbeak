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
        return [
            'user_id' => random_int(1,1000),
            'name' => $this->faker->name(),
            'description'=> $this->faker->text(),
            'category_id' => random_int(1,1000),
            'country_id' => random_int(1,250),
            'status_id' => random_int(1,1000),
        ];
    }
}
