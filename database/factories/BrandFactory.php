<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'thumbnail' => $this->faker->img('brands', 'brands'),
            'sorting' => $this->faker->numberBetween(1, 999),
            'on_home_page' => $this->faker->boolean(),
        ];
    }
}
