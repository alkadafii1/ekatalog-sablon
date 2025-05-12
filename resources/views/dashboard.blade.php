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
                    
                    <!-- Konten dashboard lainnya -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Total Produk</h5>
                                    <p class="card-text display-4">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Produk Tersedia</h5>
                                    <p class="card-text display-4">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Produk Habis</h5>
                                    <p class="card-text display-4">0</p>
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