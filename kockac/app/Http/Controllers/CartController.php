<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        if (auth()->check()) {
            $cart = Cart::with('items.product.images')
                ->where('user_id', auth()->id())
                ->first();
        } else {
            $cart = Cart::with('items.product.images')
                ->where('session_token', session()->getId())
                ->first();
        }
        return view('cart', ['cart' => $cart]);
    }

    public function update(Request $request, $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $item = CartItem::findOrFail($cartItem);
        $item->update(['quantity' => $request->quantity]);

        $cart = Cart::with('items.product')->findOrFail($item->cart_id);
        $total = $cart->items->sum(fn($i) => $i->quantity * $i->product->price);

        return response()->json(['success' => true, 'total' => $total]);
    }

    public function destroy($cartItem)
    {
        $item = CartItem::findOrFail($cartItem);
        $cartId = $item->cart_id;
        $item->delete();

        $cart = Cart::with('items.product')->findOrFail($cartId);
        $total = $cart->items->sum(fn($i) => $i->quantity * $i->product->price);

        return response()->json(['success' => true, 'total' => $total]);
    }
}
