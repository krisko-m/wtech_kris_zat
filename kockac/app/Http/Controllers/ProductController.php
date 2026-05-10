<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Genre;
use App\Models\ProductImage;
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

        $currentQty = $cartItem ? $cartItem->quantity : 0;
        if ($currentQty + $request->quantity > $product->stock_quantity) {
            return redirect()->back()->with('error',
                "Sorry, only {$product->stock_quantity} units of '{$product->name}' are available."
            );
        }

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

        $search       = $request->input('search');
        $priceMin     = $request->input('price_min');
        $priceMax     = $request->input('price_max');
        $players      = $request->input('players');
        $sort         = $request->input('sort', 'default');
        $ages         = $request->input('ages', []);
        $genres = $request->input('genres', []);
        if ($request->input('genre') && !in_array($request->input('genre'), $genres)) {
            $genres[] = $request->input('genre');
        }
        $complexities = $request->input('complexities', []);
        if ($request->input('complexity') && !in_array($request->input('complexity'), $complexities)) {
            $complexities[] = $request->input('complexity');
        }

        $products = Product::with('mainImage')
            ->withAvg('reviews', 'stars')
            ->when($search, function($query) use ($search){
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('author', 'ilike', '%' . $search . '%')
                        ->orWhere('publisher', 'ilike', '%' . $search . '%');
                });
            })
            ->when(!empty($genres), function ($q) use ($genres) {
                $q->whereHas('genres', fn($q) => $q->whereIn('genre_type', $genres));
            })
            ->when(!empty($complexities), fn($q) => $q->whereIn('complexity', $complexities))
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
            ->when($sort === 'newest',     fn($q) => $q->orderByDesc('created_at'))
            ->when($sort === 'default',    fn($q) => $q->orderByRaw('(SELECT COALESCE(AVG(stars), 0) FROM reviews WHERE reviews.product_id = products.product_id) DESC'))
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
            ->when($sort === 'newest',     fn($q) => $q->orderByDesc('created_at'))
            ->when($sort === 'default',    fn($q) => $q->orderByRaw('(SELECT COALESCE(AVG(stars), 0) FROM reviews WHERE reviews.product_id = products.product_id) DESC'))            ->paginate(8)->withQueryString();

        return view('admin/product-overview-admin', compact('products'));
    }

    public function store(Request $request){
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
            'main_image_id'  => 'nullable|integer',
            'image_ids'      => 'nullable|array',
            'genres'         => 'required|array|min:1',
            'genres.*'       => 'string|in:Family,Puzzle,Card Games,Strategic,Party',
        ]);

        $product = Product::create($validatedData);

        if ($request->main_image_id) {
            ProductImage::where('image_id', $request->main_image_id)
                ->update(['product_id' => $product->product_id, 'is_main' => true]);
        }

        if ($request->image_ids) {
            foreach ($request->image_ids as $imageId) {
                if ($imageId) {
                    ProductImage::where('image_id', $imageId)
                        ->update(['product_id' => $product->product_id, 'is_main' => false]);
                }
            }
        }

        if ($request->genres) {
            $genreIds = Genre::whereIn('genre_type', $request->genres)->pluck('genre_id');
            foreach ($genreIds as $genreId) {
                \Illuminate\Support\Facades\DB::table('genre_of_product')->insert([
                    'genre_id'   => $genreId,
                    'product_id' => $product->product_id,
                ]);
            }
        }

        return redirect('/admin/products')->with('success', 'Product added successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // $product->images()->delete();

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function edit(Request $request, $id){
        $product = Product::with(['images', 'genres'])->findOrFail($id);

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
            'genres'         => 'required|array|min:1',
            'genres.*'       => 'string|in:Family,Puzzle,Card Games,Strategic,Party',
        ]);

        $product->update($validatedData);

        \Illuminate\Support\Facades\DB::table('genre_of_product')
            ->where('product_id', $product->product_id)
            ->delete();

        if ($request->genres) {
            $genreIds = Genre::whereIn('genre_type', $request->genres)->pluck('genre_id');
            foreach ($genreIds as $genreId) {
                \Illuminate\Support\Facades\DB::table('genre_of_product')->insert([
                    'genre_id'   => $genreId,
                    'product_id' => $product->product_id,
                ]);
            }
        }

        return redirect('/admin/products')->with('success', 'Product updated!');
    }
}
