<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Silakan login sebagai user.');
        }

        $wishlistItems = $user->wishes()->with('category')->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Product $product)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Silakan login sebagai user.');
        }

        $user->wishes()->syncWithoutDetaching([$product->id]);

        return back()->with('success', 'Produk ditambahkan ke wishlist');
    }

    public function destroy(Product $product)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Silakan login sebagai user.');
        }

        $user->wishes()->detach($product->id);

        return back()->with('success', 'Produk dihapus dari wishlist');
    }
}
