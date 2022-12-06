<?php

namespace App\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    )
    {
    }

    public function categories()
    {
        return Category::query()
            ->has('products')
            ->get();
    }

    public function products()
    {
        return Product::query()
            ->search()
            ->fromCategory($this->category)
            ->filtered()
            ->sorted()
            ->paginate(9);
    }
}
