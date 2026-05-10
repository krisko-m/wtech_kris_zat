<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId){
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'You must be logged in to write a review.');
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'stars' => $request->stars,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review submitted!');
    }
}
