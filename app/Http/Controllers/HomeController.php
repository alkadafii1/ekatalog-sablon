<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
                // Semua produk
        $products = Product::latest()->get();

        // 5 produk teratas berdasarkan kunjungan
        $topProducts = Product::orderByDesc('visits')->take(5)->get();

        return view('home', compact('products', 'topProducts'));

        $search = $request->query('search');
        $products = Product::with('supportingImages')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->where('availability', true)
            ->latest()
            ->get();

        return view('home', compact('products'));
    }
}

