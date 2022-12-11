<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function page()
    {
        return view('order.index');
    }

    public function handle()
    {
        //
    }
}
