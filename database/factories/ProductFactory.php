<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'thumbnail' => $this->faker->img('products', 'products'),
            'price' => $this->faker->numberBetween(100000, 10000000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'sorting' => $this->faker->numberBetween(1, 999),
            'on_home_page' => $this->faker->boolean(),
        ];
    }
}
