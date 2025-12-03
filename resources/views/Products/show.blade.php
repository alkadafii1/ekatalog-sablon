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
    
    /* Margin atas untuk notif */
    .alert-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* Styling untuk harga - DIKECILKAN & DIPERBAIKI */
    .product-price {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px 20px;
        margin: 20px 0;
        text-align: left;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: inline-block;
    }

    .price-label {
        color: #6c757d;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .price-amount {
        color: #28a745;
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    /* Styling untuk deskripsi */
    .product-description {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 25px;
        margin: 20px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .description-title {
        color: #333;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .description-text {
        color: #555;
        font-size: 15px;
        line-height: 1.6;
        text-align: justify;
        margin: 0;
    }

    /* Styling untuk status ketersediaan */
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

    /* Styling untuk views */
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

    /* Pastikan tombol wishlist dapat diklik */
    .wishlist-btn {
        cursor: pointer;
        position: relative;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .wishlist-btn:active {
        transform: translateY(0);
    }

    /* Pastikan form tidak mengganggu klik */
    form.d-inline {
        display: inline-block !important;
        position: relative;
        z-index: 10;
    }

    /* Hapus style yang mungkin menutupi tombol */
    .card-body {
        position: relative;
        z-index: 1;
    }

    /* Pastikan tombol WA juga konsisten */
    .btn-success {
        cursor: pointer;
        position: relative;
        z-index: 10;
    }

    /* Container untuk tombol aksi */
    .action-buttons {
        position: relative;
        z-index: 10;
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

    {{-- Gambar Produk --}}
    <img src="{{ asset('storage/' . $product->main_image) }}"
     class="img-fluid rounded-start"
     style="max-height: 700px; width: 100%; object-fit: contain; background-color: #f8f9fa; border-radius: 10px;"
     alt="{{ $product->name }}">

    <div class="card-body">
        {{-- Nama Produk + Tombol Aksi --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="card-title mb-0 text-dark">{{ $product->name }}</h3>

            {{-- Tombol Order WA --}}
            @php
                $whatsapp_number = '6289683028254';
                $product_image = asset('storage/' . $product->main_image); 

                $message = "🛍️ *PESANAN PRODUK*\n";
                $message .= "==================\n\n";
                $message .= "Halo! Saya tertarik untuk memesan produk berikut:\n\n";
                $message .= "✨ *{$product->name}*\n";
                $message .= "📂 Kategori: {$product->category->nama}\n";
                $message .= "🖼️ Gambar: {$product_image}\n\n";
                $message .= "==================\n";
                $message .= "Apakah produk ini tersedia dan bisa dipesan?\n\n";
                $message .= "Terima kasih! 🙏";
                $encoded_message = urlencode($message);
            @endphp

            <div class="d-flex flex-wrap gap-3 action-buttons">
                {{-- Tombol WA --}}
                <a 
                    href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                    class="btn btn-success d-flex align-items-center"
                    target="_blank"
                >
                    <i class="fab fa-whatsapp me-2"></i> Pesan via WA
                </a>

                {{-- Tombol Wishlist --}}
                @auth
                <form action="{{ route('wishlist.store', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center wishlist-btn">
                        <i class="fas fa-heart me-2"></i> Tambah ke Wishlist
                    </button>
                </form>
                @else
                <a href="{{ route('user.login') }}" class="btn btn-outline-danger d-flex align-items-center">
                    <i class="fas fa-heart me-2"></i> Tambah ke Wishlist
                </a>
                @endauth
            </div>
        </div>

        {{-- Info Views dan Ketersediaan --}}
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

        {{-- Harga Produk dengan Styling yang Lebih Kecil dan Rapi --}}
        <div class="product-price">
            <div class="price-label">Harga</div>
            <h2 class="price-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
        </div>
        
        {{-- Deskripsi Produk --}}
        <div class="product-description">
            <h4 class="description-title">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                Deskripsi Produk
            </h4>
            <p class="description-text">{{ $product->description }}</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug tombol wishlist
    const wishlistBtn = document.querySelector('.wishlist-btn');
    const wishlistForm = document.querySelector('form[action*="wishlist"]');
    
    console.log('Tombol wishlist:', wishlistBtn);
    console.log('Form wishlist:', wishlistForm);
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            console.log('Tombol wishlist diklik');
            // Tampilkan loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menambahkan...';
            this.disabled = true;
            
            // Submit form setelah delay kecil
            setTimeout(() => {
                if (wishlistForm) {
                    wishlistForm.submit();
                }
            }, 100);
        });
    }
    
    if (wishlistForm) {
        wishlistForm.addEventListener('submit', function(e) {
            console.log('Form wishlist disubmit');
        });
    }

    // Cek apakah ada elemen yang menutupi tombol
    function checkElementOverlap(element) {
        const rect = element.getBoundingClientRect();
        const x = rect.left + rect.width / 2;
        const y = rect.top + rect.height / 2;
        
        const topElement = document.elementFromPoint(x, y);
        console.log('Element di atas tombol:', topElement);
        
        return topElement !== element;
    }

    // Test overlap setelah halaman dimuat
    setTimeout(() => {
        const wishlistButton = document.querySelector('.wishlist-btn');
        if (wishlistButton) {
            const isOverlapped = checkElementOverlap(wishlistButton);
            console.log('Tombol wishlist tertutup:', isOverlapped);
            
            if (isOverlapped) {
                console.warn('PERINGATAN: Tombol wishlist mungkin tertutup oleh elemen lain!');
            }
        }
    }, 1000);
});
</script>
@endsection