<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SupportingImage;
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'required|image',
            'supporting_images.*' => 'image',
            //'availability' => 'required|boolean',
            'availability' => 'required|in:0,1',
            'category_id' => 'required|exists:categories,id', // Validasi kategori wajib dipilih
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
        ]);

        // Simpan gambar pendukung jika ada
        if ($request->hasFile('supporting_images')) {
            foreach ($request->file('supporting_images') as $image) {
                $imagePath = $image->store('supporting_images', 'public');
                SupportingImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Kirim data kategori ke view
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'availability' => 'required|in:0,1',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'supporting_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id', 
        ]);

        // Update Data Produk
        $product->name = $request->name;
        $product->description = $request->description;
        $product->availability = $request->availability;
        $product->category_id = $request->category_id; 

        // Update Gambar Utama
        if ($request->hasFile('main_image')) {
            // Hapus gambar lama jika ada
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            // Simpan gambar baru
            $product->main_image = $request->file('main_image')->store('products', 'public');
        }

        // Update Gambar Pendukung (Optional)
        if ($request->hasFile('supporting_images')) {
            $supportingImages = [];

            // Hapus gambar pendukung lama jika ada
            if ($product->supporting_images) {
                $oldImages = json_decode($product->supporting_images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Simpan gambar pendukung baru
            foreach ($request->file('supporting_images') as $image) {
                $supportingImages[] = $image->store('products', 'public');
            }
            $product->supporting_images = json_encode($supportingImages);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus Gambar Utama
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        // Hapus Gambar Pendukung
        if ($product->supporting_images) {
            $supportingImages = json_decode($product->supporting_images, true);
            foreach ($supportingImages as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Hapus Produk
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Tambah jumlah kunjungan
        $product->increment('visits');

        return view('products.show', compact('product'));
    }
}
