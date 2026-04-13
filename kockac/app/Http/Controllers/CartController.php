<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $sessionToken = session()->getId();
        $cart = Cart::with('items.product')->where('session_token', $sessionToken)->first();
        return view('cart', ['cart' => $cart]);
    }
}
