<?php

namespace Domain\Catalog\Filters;

class FilterManager
{
    public function __construct(protected array $items = [])
    {
    }

    public function registerFilters(array $filters)
    {
        $this->items = $filters;
    }

    public function items(): array
    {
        return $this->items;
    }
}
