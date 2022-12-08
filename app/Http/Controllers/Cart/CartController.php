<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('cart.index', [
            'items' => cart()->items()
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add(
            $product,
            request('quantity', 1),
            request('options', [])
        );

        flash()->info('Товар добавлен в корзину');

        return redirect()
            ->intended('cart');
    }

    public function quantity(CartItem $item): RedirectResponse
    {
        cart()->quantity($item, request('quantity', 1));

        flash()->info('Кол-во изменено');

        return redirect()
            ->intended('cart');
    }

    public function delete(CartItem $item): RedirectResponse
    {
        cart()->delete($item);

        flash()->info('Товар удален из корзины');

        return redirect()
            ->intended('cart');
    }

    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()
            ->intended('cart');
    }
}
