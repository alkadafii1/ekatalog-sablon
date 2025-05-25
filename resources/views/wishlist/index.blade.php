@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Wishlist Anda</h2>
    
    @forelse($wishlistItems as $product)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">
                                Kategori: {{ $product->category->nama }}
                            </small>
                        </p>
                        <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Hapus dari Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Wishlist Anda kosong</div>
    @endforelse
</div>
@endsection