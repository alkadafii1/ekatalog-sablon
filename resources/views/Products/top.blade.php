@extends('layouts.apperance')

@section('title', 'Produk Teratas')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-left: 5px solid #4E71FF;
        padding-left: 1rem;
    }
    .product-card {
        transition: 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.07);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .product-img {
        height: 200px;
        object-fit: cover;
    }
    .badge-category {
        background-color: #f0f0f0;
        color: #4E71FF;
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
        border-radius: 50px;
    }
</style>

<h2 class="section-title"><i class="fas fa-fire text-danger"></i> Produk Teratas</h2>

<div class="row">
    @forelse ($topProducts as $product)
        <div class="col-md-3 mb-4">
            <div class="card product-card">
                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                <div class="card-body">
                    <span class="badge badge-category mb-2"><i class="fas fa-star me-1 text-warning"></i> Most Viewed </span>
                    <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada produk teratas.</p>
    @endforelse
</div>
@endsection
