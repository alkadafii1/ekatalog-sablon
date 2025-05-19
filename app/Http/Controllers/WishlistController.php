<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
{
    // Simulasi data dummy produk wishlist (jika belum pakai database)
    $wishlists = collect([
        (object)[
            'id' => 1,
            'name' => 'Produk Dummy 1',
            'main_image' => 'images/sample-product.jpg',
            'description' => 'Deskripsi singkat produk dummy 1',
        ],
        (object)[
            'id' => 2,
            'name' => 'Produk Dummy 2',
            'main_image' => 'images/sample-product.jpg',
            'description' => 'Deskripsi singkat produk dummy 2',
        ],
    ]);

    return view('wishlist.index', compact('wishlists'));
}

}
