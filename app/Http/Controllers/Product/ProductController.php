<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $also = Product::query()
            ->when(session()->has('also'), function (Builder $q) use ($product) {
               $q->whereIn('id', session('also'))
                    ->whereNot('id', $product->id)
                    ->limit(4);
            })
            ->get();

        session()->put('also.' . $product->id, $product->id);

        $product->load('optionValues.option');

        $options = $product->optionValues->mapToGroups(function($item) {
            return [$item->option->title => $item];
        });

        return view('product.show', compact('product', 'options', 'also'));
    }
}
