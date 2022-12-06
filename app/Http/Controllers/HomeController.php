<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Product\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::homePage()->get();
        $brands = BrandViewModel::make()->homePage();
        $categories = Category::all();

        return view('home', compact('products', 'brands', 'categories'));
    }
}
