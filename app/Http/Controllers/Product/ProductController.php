<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\ViewModels\ProductViewModel;
use Domain\Product\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product): ProductViewModel
    {
        session()->put('also.' . $product->id, $product->id);

        return (new ProductViewModel($product))->view('product.show');

    }
}
