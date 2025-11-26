<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        // Menampilkan view dengan produk yang sudah difilter
        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Ambil semua kategori untuk form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:255',
        'main_image' => 'required|image',
        'availability' => 'required|in:0,1',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
    ]);

    // Simpan gambar utama
    $mainImagePath = $request->file('main_image')->store('product_images', 'public');

    // Simpan produk
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'main_image' => $mainImagePath,
        'availability' => $request->availability,
        'category_id' => $request->category_id,
        'price' => $request->price, 
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
}


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        return view('products.edit', compact('product', 'categories'));
    }

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validasi Input
    $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:255',
        'availability' => 'required|in:0,1',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
    ]);

    // Update Data Produk
    $product->name = $request->name;
    $product->description = $request->description;
    $product->availability = $request->availability;
    $product->category_id = $request->category_id; 
    $product->price = $request->price; // Update harga

    // Update Gambar Utama
    if ($request->hasFile('main_image')) {
        // Hapus gambar lama jika ada
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        // Simpan gambar baru
        $product->main_image = $request->file('main_image')->store('products', 'public');
    }


    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus Gambar Utama
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        // Hapus Produk
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
;
        // Tambah jumlah kunjungan
        $product->increment('visits');

        return view('products.show', compact('product'));
    }

    public function byCategory($kategori)
    {
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($kategori) {
                $query->where('nama', 'like', "%$kategori%");
            })
            ->latest()
            ->get();

        $categories = Category::all();

        return view('products.by-category', compact('products', 'kategori'));
    }


}
