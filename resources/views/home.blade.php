@extends('layouts.apperance')

@section('title', 'Beranda')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    :root {
        --primary-color: #B8860B;
        --primary-gradient: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        --secondary-gradient: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
        --accent-gradient: linear-gradient(135deg, #CD853F 0%, #DEB887 100%);
        --luxury-gradient: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        --brown-gradient: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        --card-shadow: 0 10px 30px rgba(212, 175, 55, 0.15);
        --card-shadow-hover: 0 20px 60px rgba(212, 175, 55, 0.25);
    }

    body {
        min-height: 100vh;
    }

    /* Header Hero Section */
    .hero-section {
        background: var(--primary-gradient);
        border-radius: 24px;
        padding: 4rem 2rem;
        margin-bottom: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    /* Search Section */
    .search-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 3rem;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .search-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        border: 2px solid #F4E4BC;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: #FFFEF7;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
        background: white;
    }

    .btn-primary-custom {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
    }

    /* Category Navigation Cards */
    .category-nav {
        margin-bottom: 4rem;
    }

    .category-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(212, 175, 55, 0.2);
        position: relative;
        overflow: hidden;
        display: block;
        min-height: 200px;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--primary-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: var(--card-shadow-hover);
        text-decoration: none;
        color: white;
    }

    .category-card:hover::before {
        opacity: 1;
    }

    .category-card .card-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .category-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1);
        color: white;
    }

    .category-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        transition: color 0.3s ease;
    }

    .category-card:hover .category-title {
        color: white;
    }

    /* Section Headers */
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

    /* Product Cards */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(78, 113, 255, 0.1);
        position: relative;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-15px);
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
    }

    .badge-category {
        background: var(--brown-gradient);
        color: white;
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
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

    /* Empty State */
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

    /* Animations */
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

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-section {
            padding: 2rem 1rem;
        }
        
        .search-container {
            padding: 1.5rem;
        }
        
        .category-card {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section fade-in-up">
    <div class="hero-content">
        <h1 class="hero-title">Temukan Produk Terbaik</h1>
        <p class="hero-subtitle">Koleksi lengkap undangan dan alat bahan berkualitas tinggi untuk kebutuhan Anda</p>
    </div>
</div>

<!-- Search Section -->
<div class="search-container fade-in-up">
    <h3 class="search-title">
        <i class="fas fa-search"></i>
        Cari Produk yang Anda Butuhkan
    </h3>
    
    <form action="{{ route('home') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-5 mb-3">
                <label for="search" class="form-label fw-semibold">
                    <i class="fas fa-search me-1"></i> Nama Produk
                </label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Masukkan nama produk..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="category" class="form-label fw-semibold">
                    <i class="fas fa-tags me-1"></i> Kategori
                </label>
                <select name="category" id="category" class="form-control">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="fas fa-filter me-2"></i> Filter Produk
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Category Navigation -->
<div class="category-nav fade-in-up">
    <div class="section-header">
        <h2 class="section-title">Jelajahi Kategori</h2>
        <p class="section-subtitle">Temukan produk berdasarkan kategori yang Anda butuhkan</p>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('top.products') }}" class="category-card">
                <div class="card-content">
                    <i class="fas fa-fire category-icon" style="color: #FF4500;"></i>
                    <h5 class="category-title">Produk Teratas</h5>
                    <p class="text-muted mt-2">Produk paling populer dan terlaris</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('products.byCategory', ['kategori' => 'undangan']) }}" class="category-card">
                <div class="card-content">
                    <i class="fas fa-envelope-open-text category-icon" style="color: #D4AF37;"></i>
                    <h5 class="category-title">Undangan</h5>
                    <p class="text-muted mt-2">Blanko untuk berbagai acara</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('products.byCategory', ['kategori' => 'alat-bahan']) }}" class="category-card">
                <div class="card-content">
                    <i class="fas fa-tools category-icon" style="color: #8B4513;"></i>
                    <h5 class="category-title">Alat & Bahan</h5>
                    <p class="text-muted mt-2">Peralatan dan bahan berkualitas tinggi</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- All Products Section -->
<div class="fade-in-up">
    <div class="section-header">
        <h2 class="section-title">Semua Produk</h2>
        <p class="section-subtitle">Jelajahi koleksi lengkap produk kami yang berkualitas</p>
    </div>
    
    <div class="row">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->main_image) }}" 
                         class="product-img w-100" alt="{{ $product->name }}">
                    <div class="product-body">
                        <span class="badge-category">{{ $product->category->nama ?? 'Tanpa Kategori' }}</span>
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <a href="{{ route('products.show', $product->id) }}" class="btn-view-detail">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>Belum Ada Produk</h3>
                    <p>Produk akan segera tersedia. Silakan cek kembali nanti.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
// Add smooth scrolling and animation triggers
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = Math.random() * 0.3 + 's';
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.product-card, .category-card').forEach(card => {
        observer.observe(card);
    });
});
</script>

@endsection