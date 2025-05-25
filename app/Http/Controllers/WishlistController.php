<?php

// File: app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems =  auth::user()->wishes()->with('category')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Product $product)
    {
        auth::user()->wishes()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Produk ditambahkan ke wishlist');
    }

    public function destroy(Product $product)
    {
        auth::user()->wishes()->detach($product->id);
        return back()->with('success', 'Produk dihapus dari wishlist');
    }
}