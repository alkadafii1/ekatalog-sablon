{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <style>
        :root {
            --white: #F6F6F6;
            --brown-dark: #2F2F2F;
            --brown-light: #FFCB74;
            --red: #DC3545;
            --blue: #578FCA;
        }

        body {
            background-color: var(--white);
            font-family: Arial, sans-serif;
            color: var(--brown-dark);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: var(--brown-dark);
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--blue);
            border: none;
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #578FCA;
        }

        .btn-danger {
            background-color: var(--red);
            border: none;
        }

        .table th {
            background-color: var(--blue);
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--white);
        }

        .btn-action {
            border: none;
            font-size: 1rem;
            padding: 6px 10px;
            border-radius: 4px;
        }

        .btn-edit {
            background-color: var(--blue);
            color: var(--white);
        }

        .btn-edit:hover {
            background-color: #A1E6FD;
            color: var(--white);
        }

        .btn-delete {
            background-color: var(--blue);
            color: white;
        }

        .btn-delete:hover {
            background-color: #A1E6FD;
            color: white;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .truncate-text {
                max-width: 150px;
            }
        }
    </style>

    <div class="container">
        <h1 class="mb-4 text-center">Daftar Produk</h1>

        <div class="mb-4 d-flex justify-content-between">
            <form action="{{ route('products.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            </form>
            <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Ketersediaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="Gambar Produk" class="product-image">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td class="truncate-text">{{ $product->description }}</td>
                            <td>
                                <span class="{{ $product->availability ? 'text-success font-weight-bold' : 'text-danger font-weight-bold' }}">
                                    {{ $product->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-action btn-delete" data-toggle="modal" data-target="#deleteModal" data-id="{{ $product->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin menghapus produk ini?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            var action = "{{ route('products.destroy', ':id') }}".replace(':id', productId);
            $('#deleteForm').attr('action', action);
        });
    </script>
@endpush
