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

        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_token' => null]
            );
        } else {
            $cart = Cart::firstOrCreate(
                ['session_token' => session()->getId()],
                ['user_id' => null]
            );
        }

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
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $players = $request->input('players');
        $sort = $request->input('sort', 'default');
        $ages = $request->input('ages', []);

        $products = Product::with('mainImage')
            ->distinct()
            ->withAvg('reviews', 'stars')
            ->when($search, function($query) use ($search){
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('author', 'ilike', '%' . $search . '%')
                        ->orWhere('publisher', 'ilike', '%' . $search . '%');
                });
            })
            ->when($priceMin, fn($q) => $q->where('price', '>=', $priceMin))
            ->when($priceMax, fn($q) => $q->where('price', '<=', $priceMax))
            ->when($players, fn($q) => $q->where('players_min', '<=', $players)
                ->where(function($q) use ($players) {
                    $q->where('players_max', '>=', $players)
                        ->orWhereNull('players_max');
                }))
            ->when(!empty($ages), function ($q) use ($ages) {
                $q->where(function($q) use ($ages) {
                    foreach ($ages as $age) {
                        $q->orWhere('recommended_age', '<=', $age);
                    }
                });
            })
            ->when($sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'name_asc',   fn($q) => $q->orderBy('name'))
            ->when($sort === 'default',    fn($q) => $q->orderByDesc('reviews_avg_stars'))
            ->paginate(8)->withQueryString();

        return view('product.products', compact('products'));
    }

    public function adminIndex(Request $request)
    {
        $search   = $request->input('search');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $players  = $request->input('players');
        $sort     = $request->input('sort', 'default');
        $ages     = $request->input('ages', []);

        $products = Product::with('mainImage')
            ->distinct()
            ->withAvg('reviews', 'stars')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('author', 'ilike', '%' . $search . '%')
                        ->orWhere('publisher', 'ilike', '%' . $search . '%');
                });
            })
            ->when($priceMin, fn($q) => $q->where('price', '>=', $priceMin))
            ->when($priceMax, fn($q) => $q->where('price', '<=', $priceMax))
            ->when($players, fn($q) => $q->where('players_min', '<=', $players)
                ->where(function ($q) use ($players) {
                    $q->where('players_max', '>=', $players)
                        ->orWhereNull('players_max');
                }))
            ->when(!empty($ages), function ($q) use ($ages) {
                $q->where(function ($q) use ($ages) {
                    foreach ($ages as $age) {
                        $q->orWhere('recommended_age', '<=', $age);
                    }
                });
            })
            ->when($sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'name_asc',   fn($q) => $q->orderBy('name'))
            ->when($sort === 'default',    fn($q) => $q->orderByDesc('reviews_avg_stars'))
            ->paginate(8)->withQueryString();

        return view('admin/product-overview-admin', compact('products'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'publisher'      => 'nullable|string|max:255',
            'price'          => 'required|integer|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'complexity'     => 'required|in:beginner,gateway,intermediate,expert,hardcore',
            'description'    => 'required|string',
            'recommended_age'=> 'nullable|string',
            'duration_min'   => 'nullable|integer',
            'duration_max'   => 'nullable|integer',
            'players_min'    => 'nullable|integer',
            'players_max'    => 'nullable|integer',
            'gameplay'       => 'nullable|string',
            'contents'       => 'nullable|string',
        ]);

        Product::create($validatedData);
        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // $product->images()->delete();

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function edit(Request $request, $id){
        $product = Product::findOrFail($id);

        return view('/admin/edit-product-admin', compact('product'));
    }

    public function update(Request $request, $id){
        $product = Product::findOrFail($id);
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'publisher'      => 'nullable|string|max:255',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'complexity'     => 'required|in:beginner,gateway,intermediate,expert,hardcore',
            'description'    => 'required|string',
            'recommended_age'=> 'nullable|string',
            'duration_min'   => 'nullable|integer',
            'duration_max'   => 'nullable|integer',
            'players_min'    => 'nullable|integer',
            'players_max'    => 'nullable|integer',
            'gameplay'       => 'nullable|string',
            'contents'       => 'nullable|string',
        ]);

        $product->update($validatedData);

        return redirect('/admin/products')->with('success', 'Product updated!');
    }
}
