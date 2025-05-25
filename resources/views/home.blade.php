@extends('layouts.apperance')

@section('title', 'Beranda')

@section('content')
<style>
    .btn-brown {
        background-color: #FFCB74;
        color: white;
    }
    .btn-outline-brown {
        border-color: #FFCB74;
        color: #FFCB74;
    }
    .btn-outline-brown:hover {
        background-color: #FFCB74;
        color: white;
    }
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>

<form action="{{ route('home') }}" method="GET" class="mb-4">
    <div class="form-row align-items-end">
        <div class="col-md-4">
            <label for="search">Cari Produk</label>
            <input type="text" name="search" id="search" class="form-control"
                   placeholder="Nama produk..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label for="category">Kategori</label>
            <select name="category" id="category" class="form-control">
                <option value="">-- Semua Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-brown btn-block">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('home') }}" class="btn btn-secondary btn-block">Reset</a>
        </div>
    </div>
</form>

<h2 class="section-title">🔥 Produk Teratas</h2>
<div class="row">
    @foreach ($topProducts as $product)
        <div class="col-md-3 mb-4">
            <div class="card product-card">
                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>

            @php
                $whatsapp_number = '6289683028254';
                $product_image = asset('storage/' . $product->main_image); 
                
                $message = "Halo, saya ingin memesan produk berikut:\n\n";
                $message .= "✨ *{$product->name}*\n";
                $message .= "▫️ Kategori: {$product->category->nama}\n";
                $message .= "▫️ Deskripsi: {$product->description}\n";
                $message .= "▫️ Gambar: {$product_image}\n\n"; 
                $message .= "Apakah produk ini tersedia?";
                $encoded_message = urlencode($message);
            @endphp

            <a 
                href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                class="btn btn-sm btn-success mb-2"
                target="_blank"
            >
                📲 Pesan via WA
            </a>
                    
                    <!-- Tombol Wishlist -->
                    @auth
                        <form action="{{ route('wishlist.store', $product) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ auth()->user()->wishes->contains($product->id) ? 'btn-danger' : 'btn-outline-danger' }}">
                                @if(auth()->user()->wishes->contains($product->id))
                                    ❤️ Hapus dari Wishlist
                                @else
                                    ♡ Tambah ke Wishlist
                                @endif
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger mb-2">♡ Tambah ke Wishlist</a>
                    @endauth
                    
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<h2 class="section-title">📦 Semua Produk</h2>
<div class="row">
    @foreach ($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card product-card">
                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>

            @php
                $whatsapp_number = '6289683028254';
                $product_image = asset('storage/' . $product->main_image); 
                
                $message = "Halo, saya ingin memesan produk berikut:\n\n";
                $message .= "✨ *{$product->name}*\n";
                $message .= "▫️ Kategori: {$product->category->nama}\n";
                $message .= "▫️ Deskripsi: {$product->description}\n";
                $message .= "▫️ Gambar: {$product_image}\n\n"; 
                $message .= "Apakah produk ini tersedia?";
                $encoded_message = urlencode($message);
            @endphp

            <a 
                href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                class="btn btn-sm btn-success mb-2"
                target="_blank"
            >
                📲 Pesan via WA
            </a>
                    
                    <!-- Tombol Wishlist -->
                    @auth
                        <form action="{{ route('wishlist.store', $product) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ auth()->user()->wishes->contains($product->id) ? 'btn-danger' : 'btn-outline-danger' }}">
                                @if(auth()->user()->wishes->contains($product->id))
                                    ❤️ Hapus dari Wishlist
                                @else
                                    ♡ Tambah ke Wishlist
                                @endif
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger mb-2">♡ Tambah ke Wishlist</a>
                    @endauth
                    
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection