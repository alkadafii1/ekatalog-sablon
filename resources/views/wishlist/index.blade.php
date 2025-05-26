@extends('layouts.apperance')

@section('content')
<div class="container my-4">

    {{-- Area utama Wishlist --}}
    <div class="card p-4 shadow" style="border-radius: 12px">

        <h2 class="mb-4">Wishlist Anda</h2>

        @if($wishlistItems->count())

            {{-- Tombol Pesan via WA di kanan atas --}}
            <div class="d-flex justify-content-end mb-3">
                <button type="button" id="pesanViaWA" class="btn btn-success">
                    <i class="fab fa-whatsapp me-1"></i> Pesan Produk Terpilih
                </button>
            </div>

            <form id="formWishlist">
                @foreach($wishlistItems as $product)
                    <div class="card mb-3 shadow-sm px-3 py-3 rounded-4" style="min-height: 180px;">
                        <div class="row g-0 align-items-center">

                            {{-- Checkbox --}}
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <input type="checkbox" name="produk[]"
                                    data-name="{{ $product->name }}"
                                    data-category="{{ $product->category->nama }}"
                                    data-description="{{ $product->description }}"
                                    data-image="{{ asset('storage/' . $product->main_image) }}"
                                    data-available="{{ $product->availability }}"
                                    class="form-check-input"
                                    style="transform: scale(1.5); margin: 10px;"
                                    {{ !$product->availability ? 'disabled' : '' }}>
                            </div>

                            {{-- Gambar Produk --}}
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                <div class="w-100" style="height: 150px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px;">
                                    <img src="{{ asset('storage/' . $product->main_image) }}"
                                         alt="{{ $product->name }}"
                                         style="max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 8px;">
                                </div>
                            </div>

                            {{-- Informasi Produk --}}
                            <div class="col-md-7 px-3">
                                <div class="card-body">
                                    <h4 class="card-title mb-1">{{ $product->name }}</h4>
                                    <span class="{{ $product->availability ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                        {{ $product->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                    <p class="card-text">
                                        <small class="text-muted">Kategori: {{ $product->category->nama }}</small>
                                    </p>
                                </div>
                            </div>

                            {{-- Tombol Hapus --}}
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <form action="{{ route('wishlist.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus dari wishlist?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger px-3 py-2"
                                            style="font-size: 1.2rem;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </form>

        @else
            <div class="alert alert-info">Wishlist Anda kosong</div>
        @endif

    </div>
</div>

{{-- Script untuk WhatsApp --}}
<script>
document.getElementById('pesanViaWA')?.addEventListener('click', function() {
    let checkedProducts = document.querySelectorAll('input[name="produk[]"]:checked');

    if (checkedProducts.length === 0) {
        alert('Pilih minimal 1 produk untuk dipesan via WhatsApp.');
        return;
    }

    let unavailableItems = [];
    let message = "Halo, saya ingin memesan produk berikut:\n\n";

    checkedProducts.forEach(function(checkbox) {
        let available = checkbox.dataset.available === "1";

        if (!available) {
            unavailableItems.push(checkbox.dataset.name);
            return;
        }

        let name = checkbox.dataset.name;
        let category = checkbox.dataset.category;
        let description = checkbox.dataset.description;
        let image = checkbox.dataset.image;

        message += `✨ *${name}*\n`;
        message += `▫️ Kategori: ${category}\n`;
        message += `▫️ Deskripsi: ${description}\n`;
        message += `▫️ Gambar: ${image}\n\n`;
    });

    if (unavailableItems.length > 0) {
        alert("Produk berikut tidak tersedia dan tidak dapat dipesan:\n- " + unavailableItems.join("\n- "));
        return;
    }

    message += "Apakah produk ini tersedia?";
    let encodedMessage = encodeURIComponent(message);
    let waNumber = "6289683028254"; 
    let waLink = `https://wa.me/${waNumber}?text=${encodedMessage}`;
    window.open(waLink, '_blank');
});
</script>
@endsection
