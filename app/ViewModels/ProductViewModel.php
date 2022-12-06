<?php

namespace App\ViewModels;

use Domain\Product\Models\Product;
use Spatie\ViewModels\ViewModel;

class ProductViewModel extends ViewModel
{
    public function __construct(
        public Product $product
    )
    {
        $this->product->load('optionValues.option');
    }

    public function also()
    {
     return Product::query()
         ->also($this->product)
         ->get();
    }

    public function options()
    {
        return $this->product->optionValues
            ->keyValues();
    }
}
