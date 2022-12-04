<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        if ($alsoIds = session('also')) {
            $alsoProducts = Product::query()
                ->whereIn('id',  $alsoIds)
                ->whereNot('id', $product->id)
                ->limit(4)
                ->get();
        }

        session()->put('also.' . $product->id, $product->id);

        $product->load('optionValues.option');

        $options = $product->optionValues->mapToGroups(function($item) {
            return [$item->option->title => $item];
        });

        return view('product.index', compact('product', 'options', 'alsoProducts'));
    }
}
