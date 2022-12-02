<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use function Clue\StreamFilter\fun;

class CatalogController extends Controller
{
    public function __invoke(Category $category): View
    {
        $brands = Brand::query()
            ->has('products')
            ->get();

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
            ->when(request('filters.brands'), function (Builder $query) {
                $query->whereIn('brand_id', request('filters.brands'));
            })
            ->when(request('filters.price'), function (Builder $query) {
                $query->whereBetween(
                    'price',
                    [
                        request('filters.price.from', 0) * 100,
                        request('filters.price.to', 100000) * 100,
                    ]
                );
            })
            ->paginate(9);


        return view('catalog.index', compact('category','categories', 'brands', 'products'));
    }
}
