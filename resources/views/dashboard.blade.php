@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Selamat Datang di Dashboard</h2>
                    <p class="card-text">Anda telah berhasil login ke sistem.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Total Produk</h5>
                                    <p class="card-text display-4">{{ $totalProduk }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Tersedia</h5>
                                    <p class="card-text display-4">{{ $produkTersedia }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Tidak Tersedia</h5>
                                    <p class="card-text display-4">{{ $produkTidakTersedia }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Total Wishlist User</h5>
                                    <p class="card-text display-4">{{ $totalWishlistProduk }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
