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
</style>

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
                
                $message = "Halo, saya ingin memesan produk berikut:\n\n";
                $message .= "✨ *{$product->name}*\n";
                $message .= "▫️ Kategori: {$product->category->nama}\n";
                $message .= "▫️ Deskripsi: {$product->description}\n";
                $message .= "▫️ Gambar: {$product_image}\n\n"; 
                $message .= "Apakah produk ini tersedia?";
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
        @if($i <= round($product->rating ?? 0))
            <i class="fas fa-star text-warning"></i>
        @else
            <i class="far fa-star text-warning"></i>
        @endif
    @endfor
    <span>({{ number_format($product->rating ?? 0, 1) }} dari 5)</span>
</div>

{{-- Ulasan --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Ulasan Pengguna</h5>
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

{{-- Form Ulasan (placeholder, belum difungsikan) --}}
<div class="card mb-5">
    <div class="card-header">
        <h5>Tulis Ulasan Anda</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">Form ulasan belum aktif. Silakan login dan aktifkan fungsionalitas nanti.</div>
    </div>
</div>
@endsection
