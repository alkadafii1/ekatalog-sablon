@extends('layouts.app')

@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi Penjualan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Penjualan</a></li>
    <li class="breadcrumb-item active">Tambah Transaksi</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Transaksi Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transaction_date">Tanggal Transaksi *</label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" 
                               value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran *</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                            <option value="debit_card">Kartu Debit</option>
                            <option value="credit_card">Kartu Kredit</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_name">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                               value="{{ old('customer_name') }}" placeholder="Nama pelanggan (opsional)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_contact">Kontak Pelanggan</label>
                        <input type="text" class="form-control" id="customer_contact" name="customer_contact" 
                               value="{{ old('customer_contact') }}" placeholder="No. WA/Telepon (opsional)">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_status">Status Pembayaran *</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="paid">Lunas</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" 
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-12">
                    <h5>Items Penjualan</h5>
                    <div id="items-container">
                        <!-- Item rows will be added here dynamically -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-item">
                        <i class="fas fa-plus"></i> Tambah Item
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Total Transaksi</label>
                        <input type="text" class="form-control font-weight-bold text-success" 
                               id="total-amount" value="Rp 0" readonly style="font-size: 1.2rem;">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan hidden div untuk menyimpan data products -->
<div id="products-data" data-products="{{ json_encode($products) }}" style="display: none;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil data products dari hidden div
    const productsData = document.getElementById('products-data');
    const products = JSON.parse(productsData.getAttribute('data-products'));
    const itemsContainer = document.getElementById('items-container');
    let itemCount = 0;

    function addItemRow(productId = '', quantity = 1, unitPrice = '') {
        const row = document.createElement('div');
        row.className = 'item-row border p-3 mb-2 rounded';
        
        // Build options string
        let options = '<option value="">Pilih Produk</option>';
        products.forEach(product => {
            const selected = productId == product.id ? 'selected' : '';
            options += `<option value="${product.id}" data-price="${product.price}" ${selected}>
                ${product.name} - Rp ${parseInt(product.price).toLocaleString('id-ID')}
            </option>`;
        });

        row.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Produk *</label>
                        <select class="form-control product-select" name="items[${itemCount}][product_id]" required>
                            ${options}
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Quantity *</label>
                        <input type="number" class="form-control quantity-input" 
                               name="items[${itemCount}][quantity]" value="${quantity}" min="1" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Harga Satuan *</label>
                        <input type="number" class="form-control unit-price-input" 
                               name="items[${itemCount}][unit_price]" value="${unitPrice}" 
                               step="100" min="0" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="fas fa-trash"></i> Hapus
            </button>
        `;
        
        itemsContainer.appendChild(row);
        itemCount++;

        // Attach event listeners
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const unitPriceInput = row.querySelector('.unit-price-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');
        const removeBtn = row.querySelector('.remove-item');

        function calculateSubtotal() {
            const quantity = parseInt(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const subtotal = quantity * unitPrice;
            subtotalDisplay.value = 'Rp ' + subtotal.toLocaleString('id-ID');
            updateTotalAmount();
        }

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const price = selectedOption.getAttribute('data-price');
                unitPriceInput.value = price;
                calculateSubtotal();
            }
        });

        quantityInput.addEventListener('input', calculateSubtotal);
        unitPriceInput.addEventListener('input', calculateSubtotal);

        removeBtn.addEventListener('click', function() {
            row.remove();
            updateTotalAmount();
        });

        // Calculate initial subtotal
        calculateSubtotal();
    }

    function updateTotalAmount() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
            total += quantity * unitPrice;
        });
        document.getElementById('total-amount').value = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.getElementById('add-item').addEventListener('click', function() {
        addItemRow();
    });

    // Add one initial item row
    addItemRow();
});
</script>
@endpush