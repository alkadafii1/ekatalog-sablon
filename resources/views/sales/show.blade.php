@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Penjualan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Detail Transaksi: {{ $sale->transaction_number }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">No. Transaksi</th>
                        <td>{{ $sale->transaction_number }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $sale->transaction_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Pelanggan</th>
                        <td>{{ $sale->customer_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kontak</th>
                        <td>{{ $sale->customer_contact ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Total</th>
                        <td class="font-weight-bold text-success">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Metode Bayar</th>
                        <td>
                            @switch($sale->payment_method)
                                @case('cash') Cash @break
                                @case('transfer') Transfer @break
                                @case('qris') QRIS @break
                                @case('debit_card') Kartu Debit @break
                                @case('credit_card') Kartu Kredit @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($sale->payment_status == 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $sale->notes ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <h5>Items Transaksi</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Quantity</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th class="text-success">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('sales.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection