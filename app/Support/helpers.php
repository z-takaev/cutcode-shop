<?php

use App\Support\Flash\Flash;

if (!function_exists('flash')) {
    function flash()
    {
        return app(Flash::class);
    }
}
