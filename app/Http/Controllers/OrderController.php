<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function fromWishlist(Request $request)
    {
        $selectedProducts = $request->input('selected_products', []);
        
        // Validasi
        $request->validate([
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'exists:products,id'
        ]);

        // Ambil produk dengan whereIn 
        $products = Product::with('category')
            ->whereIn('id', $selectedProducts)
            ->get(); 

        // Format pesan WA
        $whatsapp_number = '6289683028254';
        $message = "Halo, saya ingin memesan produk dari wishlist:\n\n";
        
        foreach($products as $product) {
            $product_image = asset('storage/' . $product->main_image);
            $message .= "➡️ *{$product->name}*\n";
            $message .= "   Kategori: {$product->category->nama}\n";
            $message .= "   Deskripsi: {$product->description}\n";
            $message .= "   Gambar: {$product_image}\n\n";
        }
        
        $message .= "Total produk: " . count($products) . "\n";
        $message .= "Mohon info ketersediaan dan total harganya.";
        
        $encoded_message = urlencode($message);
        
        return redirect()->away("https://wa.me/{$whatsapp_number}?text={$encoded_message}");
    }
}