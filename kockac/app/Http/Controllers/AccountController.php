<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\City;

class AccountController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load('city');
        $cities = City::orderBy('city')->get();
        return view('myaccount.myaccount', compact('user', 'cities'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name'  => 'required|string|max:50',
            'last_name'   => 'required|string|max:50',
            'address'     => 'nullable|string|max:150',
            'postal_code' => 'nullable|string|max:10',
            'city_name'   => 'nullable|string|max:60',
            'country'     => 'nullable|string|max:50',
        ]);

        $cityId = null;
        if ($request->city_name && $request->postal_code) {
            $city = City::firstOrCreate(
                ['postal_code' => $request->postal_code],
                [
                    'city'        => $request->city_name,
                    'postal_code' => $request->postal_code,
                    'country'     => $request->country ?? 'Slovakia',
                ]
            );
            $cityId = $city->city_id;
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'address'    => $request->address,
            'city_id'    => $cityId ?? $user->city_id,
        ]);

        return redirect('/account')->with('success', 'Account updated successfully!');
    }

    public function orders()
    {
        $orders = Order::with(['items.product.images', 'status'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('myaccount.orders', compact('orders'));
    }

    public function changePassword()
    {
        return view('myaccount.changepsswrd');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect('/account')->with('success', 'Password changed successfully!');
    }
}
