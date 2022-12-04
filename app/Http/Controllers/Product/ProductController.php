<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        if ($alsoIds = session('also')) {
            $alsoProducts = Product::query()
                ->whereIn('id',  $alsoIds)
                ->whereNot('id', $product->id)
                ->get();
        }

        session()->put('also.' . $product->id, $product->id);

        return view('product.index', compact('product', 'alsoProducts'));
    }
}
