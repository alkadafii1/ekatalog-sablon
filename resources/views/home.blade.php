@extends('layouts.apperance')

@section('title', 'Beranda')

@section('content')
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
           <style>
            .btn-brown {
                background-color: #FFCB74;
                color: white;
            }
            </style>

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
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <!-- <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p> -->
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
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <!-- <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p> -->
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
