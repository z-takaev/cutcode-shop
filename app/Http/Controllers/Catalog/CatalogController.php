<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(Category $category): CatalogViewModel
    {
        return (new CatalogViewModel($category))->view('catalog.index');
    }
}
