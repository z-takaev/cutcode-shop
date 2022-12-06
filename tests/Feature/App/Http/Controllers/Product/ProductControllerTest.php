<?php

namespace Tests\Feature\App\Http\Controllers\Product;

use App\Http\Controllers\Product\ProductController;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_success_response(): void
    {
        $product = ProductFactory::new()
            ->createOne();

        $this->get(action(ProductController::class, $product))
            ->assertViewIs('product.show')
            ->assertViewHas(['product', 'options', 'also'])
            ->assertOk();
    }
}
