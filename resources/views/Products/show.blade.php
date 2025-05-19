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
    }
</style>

<div class="card mb-4 position-relative">
    {{-- Tombol kembali --}}
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>

    {{-- Gambar Produk --}}
    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top" alt="{{ $product->name }}">

    <div class="card-body">
        {{-- Nama Produk + Wishlist --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="card-title mb-0">{{ $product->name }}</h3>

            {{-- Tombol Wishlist (siap difungsikan, dikomentari sementara) --}}
            {{--
            @auth
            <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-heart"></i>
                </button>
            </form>
            @endauth
            --}}
            <button class="btn btn-outline-danger" disabled>
                <i class="fas fa-heart"></i>
            </button>
        </div>

        {{-- Jumlah Dilihat --}}
        <p><i class="fas fa-eye text-secondary"></i> {{ $product->visits }} kali</p>

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
