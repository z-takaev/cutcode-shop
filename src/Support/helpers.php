<?php

use Domain\Catalog\Filters\FilterManager;
use Support\Flash\Flash;

if (!function_exists('filters')) {
    function filters()
    {
        return app(FilterManager::class)
            ->items();
    }
}

if (!function_exists('flash')) {
    function flash()
    {
        return app(Flash::class);
    }
}
