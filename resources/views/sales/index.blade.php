@extends('layouts.app')

@section('title', 'Daftar Penjualan')
@section('page-title', 'Daftar Transaksi Penjualan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Penjualan</h6>
                        <h3>Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-bar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Penjualan Hari Ini</h6>
                        <h3>Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
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
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Transaksi</h5>
            <div>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
                <a href="{{ route('sales.report') }}" class="btn btn-success">
                    <i class="fas fa-chart-pie"></i> Laporan
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->transaction_number }}</td>
                        <td>{{ $sale->transaction_date->format('d/m/Y') }}</td>
                        <td>{{ $sale->customer_name ?? '-' }}</td>
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
                            @if($sale->payment_status == 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection