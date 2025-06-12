<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian dan filter kategori dari request
        $search = $request->query('search');
        $categoryId = $request->query('category');

        // Query produk dengan pencarian dan filter kategori jika ada
        $products = Product::with('supportingImages', 'category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->where('availability', true)
            ->latest()
            ->get();

        // Ambil 5 produk teratas berdasarkan jumlah kunjungan
        $topProducts = Product::where('availability', true)
            ->orderByDesc('visits')
            ->take(5)
            ->get();

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('home', compact('products', 'topProducts', 'categories'));
    }
}
