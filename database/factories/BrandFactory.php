<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

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
