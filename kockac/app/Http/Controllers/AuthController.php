<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Account created! Please log in.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $sessionToken = session()->getId();
            $sessionCart = Cart::with('items')->where('session_token', $sessionToken)->first();

            if ($sessionCart) {
                $userCart = Cart::firstOrCreate(
                    ['user_id' => auth()->id()],
                    ['session_token' => null]
                );

                foreach ($sessionCart->items as $item) {
                    $existing = CartItem::where('cart_id', $userCart->cart_id)
                        ->where('product_id', $item->product_id)
                        ->first();

                    if ($existing) {
                        $existing->quantity += $item->quantity;
                        $existing->save();
                    } else {
                        $item->update(['cart_id' => $userCart->cart_id]);
                    }
                }
                $sessionCart->delete();
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Nesprávne prihlasovacie údaje.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
