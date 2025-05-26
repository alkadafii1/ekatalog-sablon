@extends('layouts.user')

@section('title', 'Wishlist Saya')

@section('content')
<h2 class="mb-4">Wishlist Saya</h2>

{{-- Simulasi wishlist produk --}}
<div class="row row-cols-1 row-cols-md-3 g-4">
    @for ($i = 1; $i <= 3; $i++)
    <div class="col">
        <div class="card h-100 shadow-sm">
            {{-- Gambar Produk --}}
            <a href="{{ route('products.show', $i) }}">
                <img src="{{ asset('images/sample-product.jpg') }}" class="card-img-top" alt="Produk {{ $i }}" style="height: 200px; object-fit: cover;">
            </a>

            {{-- Body --}}
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">
                        <a href="{{ route('products.show', $i) }}" class="text-decoration-none text-dark">
                            Produk Contoh {{ $i }}
                        </a>
                    </h5>

                    {{-- Tombol hapus dari wishlist (belum difungsikan) --}}
                   
                    <form action="{{ route('wishlist.destroy', $i) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus dari Wishlist">
                            <i class="fas fa-heart-broken"></i>
                        </button>
                    </form>
                    
                    <button class="btn btn-sm btn-outline-danger" disabled title="Belum bisa dihapus">
                        <i class="fas fa-heart-broken"></i>
                    </button>
                </div>

                {{-- Deskripsi --}}
                <p class="card-text text-truncate">Deskripsi singkat produk contoh nomor {{ $i }}.</p>
            </div>
        </div>
    </div>
    @endfor
</div>
@endsection
