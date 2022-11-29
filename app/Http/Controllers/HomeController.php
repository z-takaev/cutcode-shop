<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::homepage()->get();
        $brands = BrandViewModel::make()->homePage();
        $categories = Category::all();

        return view('home', compact('products', 'brands', 'categories'));
    }
}
