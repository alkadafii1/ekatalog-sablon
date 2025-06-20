<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $produkTersedia = Product::where('availability', 1)->count();
        $produkTidakTersedia = Product::where('availability', 0)->count();
        $totalWishlistProduk = DB::table('wishlist')->count(); // semua user

        return view('dashboard', compact(
            'totalProduk',
            'produkTersedia',
            'produkTidakTersedia',
            'totalWishlistProduk'
        ));
    }
}
