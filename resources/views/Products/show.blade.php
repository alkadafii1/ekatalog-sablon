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

    /* Styling untuk harga */
    .product-price {
        background: linear-gradient(135deg, #e3f2fd 0%, #f8f9ff 100%);
        border: 2px solid #2196f3;
        border-radius: 12px;
        padding: 20px;
        margin: 20px 0;
        text-align: center;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
    }

    .price-label {
        color: #666;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .price-amount {
        color: #2196f3;
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(33, 150, 243, 0.1);
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
        <div class="d-flex justify-content-between align-items-center mb-4">
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

            <div class="d-flex flex-wrap gap-3">
                {{-- Tombol WA --}}
                <a 
                    href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                    class="btn btn-success d-flex align-items-center"
                    target="_blank"
                >
                    <i class="fab fa-whatsapp me-2"></i> Pesan via WA
                </a>

                {{-- Tombol Keranjang --}}
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

        {{-- Harga Produk dengan Styling Profesional --}}
        <div class="product-price">
            <div class="price-label">Harga Produk</div>@extends('layouts.apperance')

@section('title', $product->name)

@section('content')

 <!-- <style>
        :root {
            --primary-brown: #8B4513;
            --secondary-brown: #A0522D;
            --accent-gold: #D4AF37;
            --light-gold: #B8860B;
            --cream: #FFF8DC;
            --light-cream: #FAEBD7;
            --beige: #F5DEB3;
            --dark-text: #3E2723;
            --shadow-primary: rgba(139, 69, 19, 0.25);
            --shadow-light: rgba(139, 69, 19, 0.15);
            --shadow-gold: rgba(212, 175, 55, 0.4);
        } -->
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

    /* Styling untuk harga */
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
        <div class="d-flex justify-content-between align-items-center mb-4">
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

            <div class="d-flex flex-wrap gap-3">
                {{-- Tombol WA --}}
                <a 
                    href="https://wa.me/{{ $whatsapp_number }}?text={{ $encoded_message }}" 
                    class="btn btn-success d-flex align-items-center"
                    target="_blank"
                >
                    <i class="fab fa-whatsapp me-2"></i> Pesan via WA
                </a>

                {{-- Tombol Keranjang --}}
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

        {{-- Harga Produk dengan Styling Profesional --}}
        <div class="product-price">
            <div class="price-label">Harga Produk</div>
            <h2 class="price-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
        </div>
        
        {{-- Deskripsi Produk dengan Styling Profesional --}}
        <div class="product-description">
            <h4 class="description-title">
                <i class="fas fa-info-circle me-2 text-warning"></i>
                Deskripsi Produk
            </h4>
            <p class="description-text">{{ $product->description }}</p>
        </div>
    </div>
</div>

{{-- Rating --}}
<!-- <div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fas fa-star text-warning me-2"></i>
            Rating Produk
        </h5>
        <div class="d-flex align-items-center">
            <div class="me-3">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= round($product->rating ?? 0) ? 'fas' : 'far' }} fa-star text-warning" style="font-size: 20px;"></i>
                @endfor
            </div>
            <span class="fs-5 text-muted">({{ number_format($product->rating ?? 0, 1) }} dari 5)</span>
        </div>
    </div>
</div> -->

{{-- Ulasan --}}
<!-- <div class="card mb-4">
    <div class="card-header">
        <h5><i class="fas fa-comments me-2"></i>Ulasan Pengguna</h5>
    </div>
    <div class="card-body">
        @if($product->reviews && $product->reviews->count())
            @foreach ($product->reviews as $review)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $review->user->name ?? 'Anonim' }}</strong> -
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                    @endfor
                    <p>{{ $review->comment }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @else
            <p>Belum ada ulasan untuk produk ini.</p>
        @endif
    </div>
</div> -->

{{-- Form Ulasan --}}
<!-- <div class="card mb-5">
    <div class="card-header">
        <h5><i class="fas fa-edit me-2"></i>Tulis Ulasan Anda</h5>
    </div>
    <div class="card-body">
        @auth
        {{-- Tampilkan error jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        {{-- Formulir input ulasan --}}
        <!-- <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf

            {{-- Rating Interaktif --}}
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
            </div>

            {{-- Komentar --}}
            <div class="mb-3">
                <label for="comment" class="form-label">Komentar</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis ulasan Anda di sini...">{{ old('comment') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
        @else
        <div class="alert alert-warning">
            Silakan <a href="{{ route('login') }}">login</a> untuk menulis ulasan.
        </div>
        @endauth
    </div>
</div> -->

{{-- CSS & Script --}}
<style>
    .star-rating .fa-star {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }
    .star-rating .fa-star.selected {
        color: #ffc107;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .fa-star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                ratingInput.value = value;

                // Reset semua bintang
                stars.forEach(s => s.classList.remove('selected'));

                // Warnai bintang sesuai rating
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });

       
        const current = parseInt(ratingInput.value);
        if (current > 0) {
            for (let i = 0; i < current; i++) {
                stars[i].classList.add('selected');
            }
        }
    });
</script>
@endsection
            <h2 class="price-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
        </div>
        
        {{-- Deskripsi Produk dengan Styling Profesional --}}
        <div class="product-description">
            <h4 class="description-title">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                Deskripsi Produk
            </h4>
            <p class="description-text">{{ $product->description }}</p>
        </div>
    </div>
</div>

{{-- Rating --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fas fa-star text-warning me-2"></i>
            Rating Produk
        </h5>
        <div class="d-flex align-items-center">
            <div class="me-3">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= round($product->rating ?? 0) ? 'fas' : 'far' }} fa-star text-warning" style="font-size: 20px;"></i>
                @endfor
            </div>
            <span class="fs-5 text-muted">({{ number_format($product->rating ?? 0, 1) }} dari 5)</span>
        </div>
    </div>
</div>

{{-- Ulasan --}}
<div class="card mb-4">
    <div class="card-header">
        <h5><i class="fas fa-comments me-2"></i>Ulasan Pengguna</h5>
    </div>
    <div class="card-body">
        @if($product->reviews && $product->reviews->count())
            @foreach ($product->reviews as $review)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $review->user->name ?? 'Anonim' }}</strong> -
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                    @endfor
                    <p>{{ $review->comment }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @else
            <p>Belum ada ulasan untuk produk ini.</p>
        @endif
    </div>
</div>

{{-- Form Ulasan --}}
<div class="card mb-5">
    <div class="card-header">
        <h5><i class="fas fa-edit me-2"></i>Tulis Ulasan Anda</h5>
    </div>
    <div class="card-body">
        @auth
        {{-- Tampilkan error jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulir input ulasan --}}
        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf

            {{-- Rating Interaktif --}}
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
            </div>

            {{-- Komentar --}}
            <div class="mb-3">
                <label for="comment" class="form-label">Komentar</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis ulasan Anda di sini...">{{ old('comment') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
        @else
        <div class="alert alert-warning">
            Silakan <a href="{{ route('login') }}">login</a> untuk menulis ulasan.
        </div>
        @endauth
    </div>
</div>

{{-- CSS & Script --}}
<style>
    .star-rating .fa-star {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }
    .star-rating .fa-star.selected {
        color: #ffc107;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .fa-star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                ratingInput.value = value;

                // Reset semua bintang
                stars.forEach(s => s.classList.remove('selected'));

                // Warnai bintang sesuai rating
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });

       
        const current = parseInt(ratingInput.value);
        if (current > 0) {
            for (let i = 0; i < current; i++) {
                stars[i].classList.add('selected');
            }
        }
    });
</script>
@endsection