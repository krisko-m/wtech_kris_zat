<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\City;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Admins cannot place orders.');
        }
        if (auth()->check()) {
            $cart = Cart::with('items.product.images')
                ->where('user_id', auth()->id())
                ->first();
        } else {
            $cart = Cart::with('items.product.images')
                ->where('session_token', session()->getId())
                ->first();
        }

        if (!$cart || $cart->items->count() === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $deliveryMethods = DeliveryMethod::all();
        $paymentMethods  = PaymentMethod::all();
        $cities          = City::orderBy('city')->get();

        $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->product->price);

        $user = auth()->user()?->load('city');

        return view('checkout', compact(
            'cart', 'subtotal', 'deliveryMethods',
            'paymentMethods', 'cities', 'user'
        ));
    }

    public function store(Request $request)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Admins cannot place orders.');
        }
        $request->validate([
            'first_name'         => 'required|string|max:50',
            'last_name'          => 'required|string|max:50',
            'email'              => 'required|email|max:100',
            'address'            => 'required|string|max:150',
            'city'               => 'required|string|max:60',
            'postal_code'        => 'required|string|max:10',
            'country'            => 'required|string|max:50',
            'delivery_method_id' => 'required|exists:delivery_methods,delivery_method_id',
            'payment_method_id'  => 'required|exists:payment_methods,payment_method_id',
            'additional_details' => 'nullable|string',
        ]);

        if (auth()->check()) {
            $cart = Cart::with('items.product')
                ->where('user_id', auth()->id())
                ->first();
        } else {
            $cart = Cart::with('items.product')
                ->where('session_token', session()->getId())
                ->first();
        }

        if (!$cart || $cart->items->count() === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return redirect('/cart')->with('error',
                    "Sorry, only {$item->product->stock_quantity} units of '{$item->product->name}' are available."
                );
            }
        }

        $city = City::firstOrCreate(
            ['postal_code' => $request->postal_code],
            [
                'city'        => $request->city,
                'postal_code' => $request->postal_code,
                'country'     => $request->country,
            ]
        );

        $orderAddress = OrderAddress::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'address'    => $request->address,
            'city_id'    => $city->city_id,
        ]);

        $subtotal = $cart->items->sum(fn($i) => $i->quantity * $i->product->price);

        $deliveryPrice = 3.99;
        $total = $subtotal + $deliveryPrice;

        $status = OrderStatus::where('status', 'pending')->first();

        $order = Order::create([
            'user_id'            => auth()->id(),
            'order_status_id'    => $status->order_status_id,
            'total_price'        => $total,
            'delivery_method_id' => $request->delivery_method_id,
            'payment_method_id'  => $request->payment_method_id,
            'order_address_id'   => $orderAddress->order_address_id,
            'additional_details' => $request->additional_details,
            'created_at'         => now(),
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'          => $order->order_id,
                'product_id'        => $item->product_id,
                'quantity'          => $item->quantity,
                'price_at_purchase' => $item->product->price,
            ]);

            $item->product->decrement('stock_quantity', $item->quantity);
        }

        $cart->items()->delete();
        $cart->delete();

        return redirect('/order-success')->with('order_id', $order->order_id);
    }
}
