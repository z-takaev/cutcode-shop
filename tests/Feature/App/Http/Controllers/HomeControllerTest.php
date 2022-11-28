<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_home_page_success(): void
    {
        BrandFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);

        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        ProductFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);

        $product = ProductFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $categories = CategoryFactory::new()
            ->count(5)
            ->create();

        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertViewIs('home')
            ->assertSee('Главная страница')
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('products.0', $product)
            ->assertViewHas('categories', $categories);
    }
}
