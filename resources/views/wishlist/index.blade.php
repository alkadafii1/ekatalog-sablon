@extends('layouts.apperance')

@section('content')
<div class="py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <h2 class="section-title mb-2">
            <i class="fas fa-heart me-2"></i>Wishlist Anda
        </h2>
        <p class="text-muted">Kelola produk favorit dan pesan langsung via WhatsApp</p>
    </div>

    @if($wishlistItems->count())
        <!-- Action Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" 
             style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2);">
            <div class="d-flex align-items-center">
                <span class="badge fs-6 me-2" 
                      style="background: var(--accent-gold); color: white; padding: 0.5rem 1rem; border-radius: 20px; box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);">
                    {{ $wishlistItems->count() }}
                </span>
                <span style="color: var(--dark-text); font-weight: 500;">produk dalam wishlist</span>
            </div>
            <button type="button" id="pesanViaWA" class="btn btn-success px-4 py-2" 
                    style="border-radius: 25px; box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3); font-weight: 600;">
                <i class="fab fa-whatsapp me-2"></i>
                Pesan Produk Terpilih
            </button>
        </div>

        <!-- Products List -->
        <form id="formWishlist">
            <div class="row g-4">
                @foreach($wishlistItems as $index => $product)
                    <div class="col-12">
                        <div class="product-card {{ !$product->availability ? 'opacity-75' : '' }}" 
                             style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                            
                            <div class="card-body">
                                <div class="row align-items-center">
                                    
                                    <!-- Checkbox -->
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="produk[]"
                                                   id="product_{{ $index }}"
                                                   data-name="{{ $product->name }}"
                                                   data-category="{{ $product->category->nama }}"
                                                   data-description="{{ $product->description }}"
                                                   data-image="{{ asset('storage/' . $product->main_image) }}"
                                                   data-available="{{ $product->availability }}"
                                                   class="form-check-input product-checkbox"
                                                   style="transform: scale(1.3); accent-color: var(--accent-gold);"
                                                   {{ !$product->availability ? 'disabled' : '' }}>
                                        </div>
                                    </div>

                                    <!-- Product Image -->
                                    <div class="col-md-3">
                                        <div class="position-relative">
                                            <div class="ratio ratio-1x1 overflow-hidden" 
                                                 style="border-radius: 15px; background: rgba(212, 175, 55, 0.1);">
                                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="product-img w-100 h-100 gambar"
                                                     style="transition: transform 0.3s ease; border-radius: 15px;">
                                            </div>
                                            @if(!$product->availability)
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-3"
                                                     style="background: rgba(139, 69, 19, 0.7); backdrop-filter: blur(2px);">
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Tidak Tersedia</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="col-md-7">
                                        <div class="h-100 d-flex flex-column justify-content-center">
                                            <h4 class="card-title mb-2">{{ $product->name }}</h4>
                                            
                                            <div class="mb-2">
                                                @if($product->availability)
                                                    <span class="badge fs-6 px-3 py-1 text-white" 
                                                          style="background: #28a745; border-radius: 15px; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Tersedia
                                                    </span>
                                                @else
                                                    <span class="badge fs-6 px-3 py-1 text-white" 
                                                          style="background: #dc3545; border-radius: 15px; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Tidak Tersedia
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mb-2">
                                                <small style="color: var(--secondary-brown); font-weight: 500;">
                                                    <i class="fas fa-tag me-1" style="color: var(--accent-gold);"></i>
                                                    Kategori: <span class="fw-semibold">{{ $product->category->nama }}</span>
                                                </small>
                                            </div>

                                            @if($product->description)
                                                <p class="card-text mb-0" style="line-height: 1.4; font-size: 0.9rem;">
                                                    {{ Str::limit($product->description, 120) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-auto">
                                        <div class="d-flex flex-column gap-2">
                                            <!-- Remove Button -->
                                            <form action="{{ route('wishlist.destroy', $product) }}" 
                                                  method="POST" 
                                                  class="remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm rounded-circle"
                                                        style="width: 40px; height: 40px; transition: all 0.3s ease;"
                                                        title="Hapus dari wishlist"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>

        <!-- Select All Controls -->
        <div class="mt-4 p-3 rounded-3" 
             style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2);">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input type="checkbox" id="selectAll" class="form-check-input" 
                           style="transform: scale(1.2); accent-color: var(--accent-gold);">
                    <label class="form-check-label fw-semibold" for="selectAll" 
                           style="color: var(--dark-text);">
                        Pilih Semua Produk Tersedia
                    </label>
                </div>
                <small style="color: var(--secondary-brown); font-weight: 500;">
                    <span id="selectedCount">0</span> produk terpilih
                </small>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-heart-broken display-1 opacity-50" style="color: var(--secondary-brown);"></i>
            </div>
            <h3 class="mb-3" style="color: var(--primary-brown);">Wishlist Anda Kosong</h3>
            <p class="mb-4" style="color: var(--secondary-brown);">Belum ada produk yang ditambahkan ke wishlist</p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-shopping-bag me-2"></i>
                Jelajahi Produk
            </a>
        </div>
    @endif

</div>

@if($wishlistItems->count())
<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const selectedCountSpan = document.getElementById('selectedCount');
    const pesanButton = document.getElementById('pesanViaWA');
    const removeForms = document.querySelectorAll('.remove-form');

    // Update selected count
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        selectedCountSpan.textContent = checkedCount;
        
        // Update button state
        pesanButton.disabled = checkedCount === 0;
        if (checkedCount === 0) {
            pesanButton.style.background = '#6c757d';
            pesanButton.style.borderColor = '#6c757d';
        } else {
            pesanButton.style.background = '#28a745';
            pesanButton.style.borderColor = '#28a745';
        }
    }

    // Select all functionality
    selectAllCheckbox?.addEventListener('change', function() {
        const availableCheckboxes = document.querySelectorAll('.product-checkbox:not([disabled])');
        availableCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    // Individual checkbox change
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            
            // Update select all state
            const availableCheckboxes = document.querySelectorAll('.product-checkbox:not([disabled])');
            const checkedAvailable = document.querySelectorAll('.product-checkbox:not([disabled]):checked');
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = availableCheckboxes.length === checkedAvailable.length && availableCheckboxes.length > 0;
                selectAllCheckbox.indeterminate = checkedAvailable.length > 0 && checkedAvailable.length < availableCheckboxes.length;
            }
        });
    });

    // WhatsApp order functionality
    pesanButton?.addEventListener('click', function() {
        const checkedProducts = document.querySelectorAll('.product-checkbox:checked');

        if (checkedProducts.length === 0) {
            alert('Pilih minimal 1 produk untuk dipesan via WhatsApp.');
            return;
        }

        let unavailableItems = [];
        let message = "🛍️ *PESANAN WISHLIST*\n";
        message += "==================\n\n";
        message += "Halo! Saya tertarik untuk memesan produk berikut:\n\n";

        checkedProducts.forEach(function(checkbox, index) {
            const available = checkbox.dataset.available === "1";

            if (!available) {
                unavailableItems.push(checkbox.dataset.name);
                return;
            }

            const name = checkbox.dataset.name;
            const category = checkbox.dataset.category;
            const description = checkbox.dataset.description;

            message += `${index + 1}. ✨ *${name}*\n`;
            message += `   📂 Kategori: ${category}\n`;
            if (description) {
                message += `   📝 Deskripsi: ${description}\n`;
            }
            message += `\n`;
        });

        if (unavailableItems.length > 0) {
            alert("Produk berikut tidak tersedia dan tidak dapat dipesan:\n- " + unavailableItems.join("\n- "));
            return;
        }

        message += "==================\n";
        message += "Mohon informasi ketersediaan dan harga produk tersebut.\n\n";
        message += "Terima kasih! 🙏";

        const encodedMessage = encodeURIComponent(message);
        const waNumber = "6289683028254";
        const waLink = `https://wa.me/${waNumber}?text=${encodedMessage}`;
        
        // Show loading state
        const originalText = pesanButton.innerHTML;
        pesanButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengarahkan...';
        pesanButton.disabled = true;

        setTimeout(() => {
            window.open(waLink, '_blank');
            pesanButton.innerHTML = originalText;
            pesanButton.disabled = false;
        }, 1000);
    });

    // Confirm delete
    removeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Hapus produk dari wishlist?')) {
                e.preventDefault();
            }
        });
    });

    // Card hover effects
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Initialize
    updateSelectedCount();
});
</script>

<!-- Custom Styles -->
<style>
.product-checkbox:checked {
    background-color: var(--accent-gold) !important;
    border-color: var(--accent-gold) !important;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    transform: scale(1.05);
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .row.align-items-center > .col-md-3 {
        margin-bottom: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between .d-flex:first-child {
        justify-content: center;
    }
}
</style>
@endif

@endsection