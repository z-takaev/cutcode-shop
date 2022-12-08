<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Cart\CartController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CartRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')
            ->controller(CartController::class)
            ->prefix('cart')
            ->group(function () {
                Route::get('/', 'index')->name('cart');
                Route::post('/{product}/add', 'add')->name('cart.add');
                Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
                Route::delete('/{item}/delete', 'delete')->name('cart.delete');
                Route::delete('/truncate', 'truncate')->name('cart.truncate');
            });
    }
}
