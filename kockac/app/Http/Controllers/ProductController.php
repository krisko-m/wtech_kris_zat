<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['genres', 'images'])->findOrFail($id);
        return view('product.show', compact('product'));
    }

    public function addToCart(Request $request, $id){
        $request->validate(['quantity'=>'required|integer|min:1']);

        $product = Product::findOrFail($id);

        $sessionToken = session()->getId();
        $cart = Cart::firstOrCreate(
            ['session_token' => $sessionToken],
            ['user_id' => auth()->id(), 'created_at' => now()]
        );

        $cartItem = CartItem::where('cart_id', $cart->cart_id)->where('product_id', $product->product_id)->first();

        if($cartItem){
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index(Request $request){

        $search = $request->input('search');
        $products = Product::with('mainImage')
            ->when($search, function($query) use ($search){
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('author', 'ilike', '%' . $search . '%')
                        ->orWhere('publisher', 'ilike', '%' . $search . '%');
                });
            })
            ->paginate(8);
        return view('product.products', compact('products'));
    }
}
