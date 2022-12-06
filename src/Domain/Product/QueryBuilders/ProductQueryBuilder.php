<?php

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function homePage(): ProductQueryBuilder
    {
        return $this
            ->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(10);
    }

    public function also(Product $product): ProductQueryBuilder
    {
        return $this
            ->when(session()->has('also'), function (Builder $q) use ($product) {
                $q->whereIn('id', session('also'))
                ->whereNot('id', $product->id)
                ->limit(4);
            });
    }

    public function search(): ProductQueryBuilder
    {
        return $this
            ->when(request('s'), function (Builder $query) {
                $query->whereFullText(['name', 'text'], request('s'));
            });
    }

    public function filtered(): ProductQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function sorted(): ProductQueryBuilder
    {
        return Sorter::run($this);

    }

    public function fromCategory(Category $category): ProductQueryBuilder
    {
        return $this
            ->when($category->exists, function (Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            });

    }
}
