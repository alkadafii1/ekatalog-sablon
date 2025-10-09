@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan & Analisis Penjualan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Penjualan</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter"></i> Filter Laporan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.report') }}" method="GET" id="reportFilter">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment_method">Metode Pembayaran</label>
                                <select class="form-control" id="payment_method" name="payment_method">
                                    <option value="">Semua Metode</option>
                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                    <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                    <option value="debit_card" {{ request('payment_method') == 'debit_card' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('sales.report') }}" class="btn btn-secondary">
                                        <i class="fas fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Pendapatan</h6>
                                <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Transaksi</h6>
                                <h3>{{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-receipt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Rata-rata Transaksi</h6>
                                <h3>Rp {{ number_format($averageTransaction, 0, ',', '.') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calculator fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Produk Terjual</h6>
                                <h3>{{ $topProducts->sum('total_quantity') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Detailed Reports -->
        <div class="row">
            <!-- Payment Method Distribution -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-credit-card"></i> Distribusi Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Metode</th>
                                        <th>Jumlah Transaksi</th>
                                        <th>Total Pendapatan</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentDistribution as $payment)
                                    @php
                                        $percentage = $totalRevenue > 0 ? ($payment->total / $totalRevenue) * 100 : 0;
                                        $percentageFormatted = number_format($percentage, 1);
                                    @endphp
                                    <tr>
                                        <td>
                                            @switch($payment->payment_method)
                                                @case('cash') Cash @break
                                                @case('transfer') Transfer @break
                                                @case('qris') QRIS @break
                                                @case('debit_card') Kartu Debit @break
                                                @case('credit_card') Kartu Kredit @break
                                            @endswitch
                                        </td>
                                        <td>{{ $payment->count }}</td>
                                        <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $percentage }}%;" 
                                                     aria-valuenow="{{ $percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $percentageFormatted }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-trophy"></i> 10 Produk Terlaris
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Terjual</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->total_quantity }}</td>
                                        <td>Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Report -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line"></i> Laporan Bulanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Total Transaksi</th>
                                        <th>Total Pendapatan</th>
                                        <th>Rata-rata per Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyData as $data)
                                    @php
                                        $average = $data->transactions > 0 ? $data->total / $data->transactions : 0;
                                        $monthName = DateTime::createFromFormat('!m', $data->month)->format('F');
                                    @endphp
                                    <tr>
                                        <td>{{ $monthName }}</td>
                                        <td>{{ $data->year }}</td>
                                        <td>{{ $data->transactions }}</td>
                                        <td>Rp {{ number_format($data->total, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($average, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Transactions -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list"></i> Detail Transaksi
                    </h5>
                    <div>
                        <button class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Metode Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->transaction_number }}</td>
                                <td>{{ $sale->transaction_date->format('d/m/Y') }}</td>
                                <td>{{ $sale->customer_name ?? '-' }}</td>
                                <td>{{ $sale->items->count() }} items</td>
                                <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @switch($sale->payment_method)
                                        @case('cash') Cash @break
                                        @case('transfer') Transfer @break
                                        @case('qris') QRIS @break
                                        @case('debit_card') Kartu Debit @break
                                        @case('credit_card') Kartu Kredit @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
    }
    .progress-bar {
        background-color: var(--primary-brown);
        border-radius: 4px;
    }
    .card {
        box-shadow: 0 2px 12px rgba(139, 69, 19, 0.1);
        border: none;
    }
    .card-header {
        background: linear-gradient(135deg, var(--cream) 0%, var(--gray-light) 100%);
        border-bottom: 1px solid var(--gray-medium);
    }
</style>
@endpush

@push('scripts')
<script>
function exportToExcel() {
    // Simple Excel export implementation
    let table = document.getElementById('transactionsTable');
    let html = table.outerHTML;
    
    // Create a blob and download link
    let blob = new Blob([html], {type: 'application/vnd.ms-excel'});
    let url = URL.createObjectURL(blob);
    let a = document.createElement('a');
    a.href = url;
    a.download = 'laporan-penjualan-' + new Date().toISOString().split('T')[0] + '.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Auto set date range to current month if not set
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (!startDate.value && !endDate.value) {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        
        startDate.value = firstDay.toISOString().split('T')[0];
        endDate.value = lastDay.toISOString().split('T')[0];
    }
});
</script>
@endpush