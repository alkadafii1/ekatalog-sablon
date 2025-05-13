@extends('layouts.apperance')

@section('title', 'Beranda')

@section('content')
    <h2 class="section-title">🔥 Produk Teratas</h2>
    <div class="row">
        @foreach ($topProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Lihat Detail</a>
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
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
