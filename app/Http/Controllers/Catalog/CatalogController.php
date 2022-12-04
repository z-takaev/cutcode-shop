<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(Category $category): View
    {
        $categories = Category::query()
            ->has('products')
            ->get();

        $products = Product::query()
            ->when(request('s'), function (Builder $query) {
                $query->whereFullText(['name', 'text'], request('s'));
            })
            ->when($category->exists, function (Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            })
            ->filtered()
            ->sorted()
            ->paginate(9);


        return view('catalog.index', compact('category','categories', 'products'));
    }
}
