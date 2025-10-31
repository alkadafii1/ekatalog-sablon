@extends('layouts.apperance')

@section('title', $product->name)

@section('content')
<style>
    .back-button {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.7);
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        object-fit: contain;
    }

    .alert-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* Layout utama horizontal */
    .product-detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 25px;
        align-items: flex-start;
    }

    .product-image {
        flex: 1 1 45%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    .product-image img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        border-radius: 10px;
    }

    .product-info {
        flex: 1 1 50%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .product-price {
        background: linear-gradient(135deg, #fff8e1 0%, #fffde7 100%);
        border-radius: 8px;
        padding: 12px 16px;
        margin: 20px 0;
        text-align: left;
        box-shadow: 0 2px 8px rgba(255, 160, 0, 0.1);
        display: inline-block;
        max-width: 300px;
    }

    .price-label {
        color: #D4AF37;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .price-amount {
        color: #D4AF37;
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(243, 219, 33, 0.1);
    }

    .product-description {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 25px;
        margin-top: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .description-title {
        color: #333;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .description-text {
        color: #555;
        font-size: 16px;
        line-height: 1.7;
        text-align: justify;
    }

    .availability-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .availability-available {
        background-color: #e8f5e8;
        color: #2e7d32;
        border: 2px solid #4caf50;
    }

    .availability-unavailable {
        background-color: #ffebee;
        color: #c62828;
        border: 2px solid #f44336;
    }

    .views-info {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px 16px;
        display: inline-flex;
        align-items: center;
        color: #666;
        font-size: 14px;
    }

    .views-info i {
        margin-right: 8px;
    }

    @media (max-width: 768px) {
        .product-detail-container {
            flex-direction: column;
        }
    }
</style>

{{-- NOTIFIKASI --}}
<div class="alert-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="card mb-4 position-relative">
    {{-- Tombol kembali --}}
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="product-detail-container">
        {{-- Gambar Produk --}}
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}">
        </div>

        {{-- Info Produk --}}
        <div class="product-info">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title mb-0 text-dark">{{ $product->name }}</h3>
                @php
                    $whatsapp_number = '6289683028254';
                    $product_image = asset('storage/' . $product->main_image);
                    $message = "🛍️ *PESANAN PRODUK*\n==================\n\nHalo! Saya tertarik untuk memesan produk berikut:\n\n✨ *{$product->name}*\n📂 Kategori: {$product->category->nama}\n🖼️ Gambar: {$product_image}\n\n==================\nApakah produk ini tersedia dan bisa dipesan?\n\nTerima kasih! 🙏";
                    $encoded_message = urlencode($message);
                @endphp

                <div class="d-flex flex-wrap gap-3">
                    <a href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                       class="btn btn-success d-flex align-items-center" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i> Pesan via WA
                    </a>
                    @auth
                        <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
                                <i class="fas fa-heart me-2"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-outline-danger d-flex align-items-center" disabled>
                            <i class="fas fa-heart me-2"></i> Tambah ke Keranjang
                        </button>
                    @endauth
                </div>
            </div>

            {{-- Info Tambahan --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="views-info">
                    <i class="fas fa-eye"></i>
                    <span>Dilihat {{ number_format($product->visits) }} kali</span>
                </div>
                <div class="availability-badge {{ $product->availability ? 'availability-available' : 'availability-unavailable' }}">
                    <i class="fas {{ $product->availability ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                    {{ $product->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                </div>
            </div>

            {{-- Harga --}}
            <div class="product-price">
                <div class="price-label">Harga Produk</div>
                <h2 class="price-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
            </div>

            {{-- Deskripsi --}}
            <div class="product-description">
                <h4 class="description-title"><i class="fas fa-info-circle me-2 text-warning"></i> Deskripsi Produk</h4>
                <p class="description-text">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
