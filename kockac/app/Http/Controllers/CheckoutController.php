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
        $deliveryMethodId = $request->delivery_method_id;
        $paymentMethodId  = $request->payment_method_id;

        $deliveryMethod = DeliveryMethod::find($deliveryMethodId);
        $paymentMethod  = PaymentMethod::find($paymentMethodId);

        $rules = [
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
        ];

        if ($deliveryMethod) {
            if ($deliveryMethod->name === 'DHL') {
                $rules['dhl_phone']   = 'required|string|max:20';
                $rules['dhl_time']    = 'required|string';
            } elseif ($deliveryMethod->name === 'Packeta') {
                $rules['packeta_city']  = 'required|string';
                $rules['packeta_point'] = 'required|string';
            } elseif ($deliveryMethod->name === 'Slovenská pošta') {
                $rules['post_city']    = 'required|string';
                $rules['post_point'] = 'required|string';
            }
        }

        if ($paymentMethod) {
            if ($paymentMethod->name === 'Kartou online') {
                $rules['card_number'] = 'required|string|min:19|max:19';
                $rules['card_name']   = 'required|string|max:100';
                $rules['card_expiry'] = 'required|string|size:5';
                $rules['card_cvv']    = 'required|string|min:3|max:4';
            }
        }

        $request->validate($rules);

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

        $deliveryMethod = DeliveryMethod::findOrFail($request->delivery_method_id);
        $deliveryPrice = $deliveryMethod->price;
        $total = $subtotal + $deliveryPrice;

        $status = OrderStatus::where('status', 'pending')->first();

        $extraDetails = [];

        if ($request->dhl_phone)    $extraDetails['dhl_phone']    = $request->dhl_phone;
        if ($request->dhl_time)     $extraDetails['dhl_time']     = $request->dhl_time;
        if ($request->dhl_address)  $extraDetails['dhl_address']  = $request->dhl_address;
        if ($request->packeta_city) $extraDetails['packeta_city'] = $request->packeta_city;
        if ($request->packeta_point)$extraDetails['packeta_point']= $request->packeta_point;
        if ($request->post_city)   $extraDetails['post_city']   = $request->post_city;
        if ($request->post_point)$extraDetails['post_point']= $request->post_point;

        if ($request->card_name)    $extraDetails['card_name']    = $request->card_name;
        if ($request->card_expiry)  $extraDetails['card_expiry']  = $request->card_expiry;
        if ($request->bank_iban)    $extraDetails['bank_iban']    = $request->bank_iban;
        if ($request->bank_name)    $extraDetails['bank_name']    = $request->bank_name;
        if ($request->bank_bank)    $extraDetails['bank_bank']    = $request->bank_bank;

        $additionalDetails = $request->additional_details
            ? array_merge($extraDetails, ['note' => $request->additional_details])
            : $extraDetails;

        $order = Order::create([
            'user_id'            => auth()->id(),
            'order_status_id'    => $status->order_status_id,
            'total_price'        => $total,
            'delivery_method_id' => $request->delivery_method_id,
            'payment_method_id'  => $request->payment_method_id,
            'order_address_id'   => $orderAddress->order_address_id,
            'additional_details' => !empty($additionalDetails) ? json_encode($additionalDetails) : null,
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
