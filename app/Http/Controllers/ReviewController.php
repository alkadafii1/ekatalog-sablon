<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'parent_id' => null
        ]);

        // Update rating produk
        $product->rating = $product->reviews()->avg('rating');
        $product->save();

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    public function storeReply(Request $request, Review $review)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);
        
        Review::create([
            'product_id' => $review->product_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'parent_id' => $review->id,
            'rating' => null
        ]);
        
        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}