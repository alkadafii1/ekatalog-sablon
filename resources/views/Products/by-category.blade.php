@extends('layouts.apperance')

@section('title', 'Produk Kategori: ' . ucfirst($kategori))

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    :root {
        --primary-color: #B8860B;
        --primary-gradient: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        --card-shadow: 0 10px 30px rgba(212, 175, 55, 0.15);
        --card-shadow-hover: 0 20px 60px rgba(212, 175, 55, 0.25);
        --badge-gradient: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(212, 175, 55, 0.1);
        box-shadow: var(--card-shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--card-shadow-hover);
    }

    .product-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .badge-category {
        background: var(--badge-gradient);
        color: white;
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        width: fit-content;
        box-shadow: 0 2px 8px rgba(139, 69, 19, 0.3);
    }

    .product-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2d3748;
        line-height: 1.4;
    }

    .btn-view-detail {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-view-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
    }

    .empty-state i {
        font-size: 4rem;
        color: #e2e8f0;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #a0aec0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>

<div class="section-header fade-in-up">
    <h2 class="section-title">
        <i class="fas fa-tags text-warning me-2"></i>Produk: {{ ucfirst($kategori) }}
    </h2>
    <p class="section-subtitle">Lihat koleksi produk dalam kategori {{ ucfirst($kategori) }}</p>
</div>

<div class="row">
    @forelse ($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 fade-in-up">
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->main_image) }}" class="product-img w-100" alt="{{ $product->name }}">
                <div class="product-body">
                    <span class="badge-category">
                        <i class="fas fa-tag me-1 text-white-50"></i> {{ $product->category->nama ?? 'Tanpa Kategori' }}
                    </span>
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <a href="{{ route('products.show', $product->id) }}" class="btn-view-detail">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state fade-in-up">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Produk dalam kategori ini belum tersedia.</p>
            </div>
        </div>
    @endforelse
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });
    });
</script>
@endsection
