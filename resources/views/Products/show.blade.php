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
        {{-- Nama Produk + Wishlist --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title mb-0">{{ $product->name }}</h3>

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
                    <i class="fab fa-whatsapp me-2"></i>  Pesan via WA
                </a>

                {{-- Tombol Wishlist --}}
                @auth
                <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
                        <i class="fas fa-heart me-2"></i>  Tambah ke Wishlist
                    </button>
                </form>
                @else
                <button class="btn btn-outline-danger d-flex align-items-center" enable>
                    <i class="fas fa-heart me-2"></i> Tambah ke Wishlist
                </button>
                @endauth
            </div>
        </div>

        {{-- Jumlah Dilihat --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p><i class="fas fa-eye text-secondary"></i> {{ $product->visits }} kali</p>
            <span class="{{ $product->availability ? 'text-success font-weight-bold' : 'text-danger font-weight-bold' }}">
            {{ $product->availability ? 'Tersedia' : 'Tidak Tersedia' }}
            </span>
        </div>
        
        {{-- Deskripsi --}}
        <p class="card-text">{{ $product->description }}</p>
    </div>
</div>

{{-- Rating --}}
<div class="mb-4">
    <strong>Rating:</strong>
    @for ($i = 1; $i <= 5; $i++)
        <i class="{{ $i <= round($product->rating ?? 0) ? 'fas' : 'far' }} fa-star text-warning"></i>
    @endfor
    <span>({{ number_format($product->rating ?? 0, 1) }} dari 5)</span>
</div>

{{-- Ulasan --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Ulasan Pengguna</h5>
    </div>
    <div class="card-body">
        {{-- 🔽 HAPUS NOTIFIKASI DARI SINI 🔽 --}}
        
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
        <h5>Tulis Ulasan Anda</h5>
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