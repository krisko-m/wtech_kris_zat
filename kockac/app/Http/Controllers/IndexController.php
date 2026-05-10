<?php

namespace App\Http\Controllers;

use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $newProducts = Product::with('mainImage')
            ->orderByDesc('created_at')
            ->limit(2)
            ->get();

        $newProductIds = $newProducts->pluck('product_id');

        $hotProducts = Product::with('mainImage')
            ->whereNotIn('product_id', $newProductIds)
            ->orderByRaw('(SELECT COALESCE(AVG(stars), 0) FROM reviews WHERE reviews.product_id = products.product_id) DESC')
            ->limit(3)
            ->get();

        return view('index', compact('newProducts', 'hotProducts'));
    }
}
