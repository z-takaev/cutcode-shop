<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use function Clue\StreamFilter\fun;

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
