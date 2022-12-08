<?php

namespace Domain\Cart\Providers;

use Domain\Cart\CartManager;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->singleton(CartManager::class, function () {
            return new CartManager(new SessionIdentityStorage());
        });
    }

    public function boot(): void
    {

    }
}
