<?php

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\Models\Brand;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BrandFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Бренд';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function values(): Collection
    {
        return Brand::query()
            ->has('products')
            ->get();
    }

    public function view(): string
    {
        return 'catalog.filters.brand';
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->when($this->requestValue(), function (Builder $q) {
                $q->whereIn('brand_id', $this->requestValue());
            });
    }
}
