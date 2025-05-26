@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Wishlist Anda</h2>

    @if($wishlistItems->count())
    <form id="formWishlist">
        @foreach($wishlistItems as $product)
            <div class="card mb-3">
                <div class="row g-0 align-items-center">
                    <div class="col-md-1 text-center">
                        <input type="checkbox" name="produk[]" 
                            data-name="{{ $product->name }}"
                            data-category="{{ $product->category->nama }}"
                            data-description="{{ $product->description }}"
                            data-image="{{ asset('storage/' . $product->main_image) }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Kategori: {{ $product->category->nama }}
                                </small>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="button" id="pesanViaWA" class="btn btn-success mt-3">
                📲 Pesan Produk Terpilih via WA
            </button>
        </div>
    </form>
    @else
        <div class="alert alert-info">Wishlist Anda kosong</div>
    @endif
</div>

{{-- Script untuk WhatsApp --}}
<script>
document.getElementById('pesanViaWA')?.addEventListener('click', function() {
    let checkedProducts = document.querySelectorAll('input[name="produk[]"]:checked');

    if (checkedProducts.length === 0) {
        alert('Pilih minimal 1 produk untuk dipesan via WhatsApp.');
        return;
    }

    let message = "Halo, saya ingin memesan produk berikut:\n\n";

    checkedProducts.forEach(function(checkbox) {
        let name = checkbox.dataset.name;
        let category = checkbox.dataset.category;
        let description = checkbox.dataset.description;
        let image = checkbox.dataset.image;

        message += `✨ *${name}*\n`;
        message += `▫️ Kategori: ${category}\n`;
        message += `▫️ Deskripsi: ${description}\n`;
        message += `▫️ Gambar: ${image}\n\n`;
    });

    message += "Apakah produk ini tersedia?";

    let encodedMessage = encodeURIComponent(message);
    let waNumber = "6289683028254"; 
    let waLink = `https://wa.me/${waNumber}?text=${encodedMessage}`;

    window.open(waLink, '_blank');
});
</script>
@endsection
