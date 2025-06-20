<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category');

        $products = Product::with('supportingImages', 'category')
            ->when($search, fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->where('availability', true)
            ->latest()
            ->get();

        $categories = Category::all();
        $wishlistCount = Auth::check() ? Auth::user()->wishes()->count() : 0;

        return view('home', compact('products', 'categories', 'wishlistCount'));
    }

    // Halaman Produk Teratas (dipanggil dari card navigasi)
    public function topProducts()
    {
        $topProducts = Product::where('availability', true)
            ->orderByDesc('visits')
            ->take(20)
            ->get();

        return view('products.top', compact('topProducts'));
    }
}
