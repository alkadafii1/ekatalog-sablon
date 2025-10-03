{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page-title', 'Manajemen Produk')

@section('breadcrumb')
    <li class="breadcrumb-item active">Daftar Produk</li>
@endsection

@push('styles')
<style>
    :root {
        --primary-brown: #8B4513;
        --secondary-brown: #A0522D;
        --light-brown: #D2B48C;
        --cream: #F5F5DC;
        --dark-brown: #654321;
        --white: #FFFFFF;
        --gray-light: #F8F9FA;
        --gray-medium: #E9ECEF;
        --gray-dark: #6C757D;
        --success: #28A745;
        --danger: #DC3545;
        --warning: #FFC107;
        --shadow: 0 2px 12px rgba(139, 69, 19, 0.1);
        --shadow-hover: 0 4px 20px rgba(139, 69, 19, 0.15);
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, var(--white) 0%, var(--cream) 100%);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-brown);
    }

    .page-header h1 {
        color: var(--primary-brown);
        font-weight: 700;
        margin: 0;
        font-size: 2rem;
    }

    .page-header p {
        color: var(--gray-dark);
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    /* Action Bar */
    .action-bar {
        background: var(--white);
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: between;
        align-items: center;
        gap: 1rem;
    }

    .search-form {
        display: flex;
        gap: 0.75rem;
        flex: 1;
        max-width: 400px;
    }

    .search-input {
        border: 2px solid var(--gray-medium);
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: var(--gray-light);
    }

    .search-input:focus {
        border-color: var(--primary-brown);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
        outline: none;
    }

    /* Custom Buttons */
    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary-brown {
        background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
        color: var(--white);
    }

    .btn-primary-brown:hover {
        background: linear-gradient(135deg, var(--secondary-brown) 0%, var(--primary-brown) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        color: var(--white);
        text-decoration: none;
    }

    .btn-search {
        background: var(--light-brown);
        color: var(--dark-brown);
    }

    .btn-search:hover {
        background: var(--secondary-brown);
        color: var(--white);
    }

    /* Table Container */
    .table-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
        padding: 1.5rem 2rem;
        color: var(--white);
    }

    .table-header h3 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Custom Table */
    .custom-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .custom-table thead th {
        background: var(--light-brown);
        color: var(--dark-brown);
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-align: left;
        border: none;
        font-size: 0.95rem;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid var(--gray-medium);
        transition: var(--transition);
    }

    .custom-table tbody tr:hover {
        background: linear-gradient(135deg, var(--cream) 0%, var(--gray-light) 100%);
    }

    .custom-table tbody tr:last-child {
        border-bottom: none;
    }

    .custom-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border: none;
    }

    /* Product Image */
    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-medium);
        transition: var(--transition);
    }

    .product-image:hover {
        border-color: var(--primary-brown);
        transform: scale(1.05);
    }

    .no-image {
        width: 60px;
        height: 60px;
        background: var(--gray-light);
        border: 2px dashed var(--gray-medium);
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-dark);
        font-size: 0.8rem;
        text-align: center;
    }

    /* Product Name */
    .product-name {
        font-weight: 600;
        color: var(--dark-brown);
        font-size: 1rem;
    }

    /* Description */
    .product-description {
        color: var(--gray-dark);
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.9rem;
    }

    /* Availability Badge */
    .availability-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .availability-available {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: var(--success);
        border: 1px solid #c3e6cb;
    }

    .availability-unavailable {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: var(--danger);
        border: 1px solid #f5c6cb;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-edit {
        background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
        color: var(--white);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #e0a800 0%, var(--warning) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        color: var(--white);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #c82333 0%, var(--danger) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-hover);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
        color: var(--white);
        border-bottom: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-body {
        padding: 2rem;
        font-size: 1.1rem;
        color: var(--dark-brown);
    }

    .modal-footer {
        border-top: 1px solid var(--gray-medium);
        padding: 1.5rem 2rem;
    }

    .btn-secondary {
        background: var(--gray-medium);
        color: var(--gray-dark);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background: var(--gray-dark);
        color: var(--white);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333 0%, var(--danger) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--gray-dark);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--light-brown);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--primary-brown);
        margin-bottom: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-form {
            max-width: none;
        }
        
        .product-description {
            max-width: 150px;
        }
        
        .action-buttons {
            flex-direction: column;
        }

    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 1.5rem;
        }
        
        .action-bar {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-boxes"></i> Daftar Produk</h1>
        <p>Kelola semua produk yang tersedia di sistem</p>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
            <input type="text" name="search" class="form-control search-input" 
                   placeholder="Cari produk berdasarkan nama atau deskripsi..." 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-custom btn-search">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
        <a href="{{ route('products.create') }}" class="btn btn-custom btn-primary-brown">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Data Produk</h3>
        </div>
        
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-image"></i> Gambar</th>
                            <th><i class="fas fa-tag"></i> Nama Produk</th>
                            <th><i class="fas fa-align-left"></i> Deskripsi</th>
                            <th><i class="fas fa-dollar-sign"></i> Harga</th>
                            <th><i class="fas fa-check-circle"></i> Ketersediaan</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" 
                                             alt="Gambar {{ $product->name }}" 
                                             class="product-image">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="product-name">{{ $product->name }}</div>
                                </td>
                                <td>
                                    <div class="product-description" title="{{ $product->description }}">
                                        {{ $product->description ?: 'Tidak ada deskripsi' }}
                                    </div>
                                <td>
                                    <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong> <!-- Menampilkan Harga -->
                                </td>
                                <td>
                                    <span class="availability-badge {{ $product->availability ? 'availability-available' : 'availability-unavailable' }}">
                                        <i class="fas fa-{{ $product->availability ? 'check' : 'times' }}"></i>
                                        {{ $product->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('products.edit', $product->id) }}" 
                                           class="btn-action btn-edit" 
                                           title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn-action btn-delete" 
                                                data-toggle="modal" 
                                                data-target="#deleteModal" 
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                title="Hapus Produk">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Mulai tambahkan produk pertama Anda untuk mengelola inventori.</p>
                <a href="{{ route('products.create') }}" class="btn btn-custom btn-primary-brown">
                    <i class="fas fa-plus"></i> Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk <strong id="productName"></strong>?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form id="deleteForm" method="POST" action="" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle delete modal
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            var productName = button.data('name');
            var action = "{{ route('products.destroy', ':id') }}".replace(':id', productId);
            
            $('#deleteForm').attr('action', action);
            $('#productName').text(productName);
        });
        
        // Add loading state to buttons
        $('.btn-primary-brown, .btn-search').on('click', function() {
            var $btn = $(this);
            var originalText = $btn.html();
            
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
            $btn.prop('disabled', true);
            
            // Re-enable after 3 seconds (fallback)
            setTimeout(function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }, 3000);
        });
        
        // Smooth hover effects
        $('.custom-table tbody tr').hover(
            function() {
                $(this).addClass('table-hover-effect');
            },
            function() {
                $(this).removeClass('table-hover-effect');
            }
        );
    });
</script>
@endpush