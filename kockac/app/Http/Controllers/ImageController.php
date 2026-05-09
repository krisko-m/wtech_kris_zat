<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $onlyUnused = $request->boolean('unused');
        $productId = $request->input('product_id');

        $images = ProductImage::when($onlyUnused, function ($query) {
            $query->whereNull('product_id');
        })
            ->when($productId && !$onlyUnused, function ($query) use ($productId) {
                $query->where(function($q) use ($productId) {
                    $q->whereNull('product_id')
                        ->orWhere('product_id', $productId);
                });
            })
            ->when(!$productId && !$onlyUnused, function ($query) {
                $query->whereNull('product_id');
            })
            ->get();

        return response()->json($images);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_id' => 'nullable|exists:products,product_id'
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('assets/images');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $image->move($destinationPath, $imageName);

        $productImage = ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => '/assets/images/' . $imageName,
            'is_main' => false,
        ]);

        return response()->json($productImage);
    }
    public function attach(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,product_id',
            'is_main' => 'boolean',
        ]);

        $image = ProductImage::findOrFail($id);
        $image->product_id = $request->product_id;
        $image->is_main = $request->boolean('is_main');
        $image->save();

        return response()->json($image);
    }

    public function detach($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->product_id = null;
        $image->is_main = false;
        $image->save();

        return response()->json($image);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        $fullPath = public_path($image->image_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}
