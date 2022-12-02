<?php

namespace App\Providers;

use App\View\Composers\NavigationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Vite::macro('image', function ($asset) {
            return $this->asset("resources/images/{$asset}");
        });

        View::composer('*', NavigationComposer::class);
    }
}
