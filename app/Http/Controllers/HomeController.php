<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::homepage()->get();
        $brands = Brand::homepage()->get();
        $categories = Category::all();

        return view('home', compact('products', 'brands', 'categories'));
    }
}
