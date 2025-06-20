@extends('layouts.apperance')

@section('title', 'Profil Saya')

@section('content')
<div class="section-title text-center">
    <h2><i class="fas fa-user-circle me-2"></i> Profil Saya</h2>
    <p class="text-muted">Kelola informasi akun dan keamanan Anda di sini.</p>
</div>

<div class="row justify-content-center">
    <!-- Informasi Profil -->
    <div class="col-lg-6 mb-4">
        <div class="card product-card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-id-badge me-2"></i> Informasi Akun</h5>
                <hr>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <!-- Ganti Password -->
    <div class="col-lg-6 mb-4">
        <div class="card product-card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-key me-2"></i> Ganti Password</h5>
                <hr>
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <!-- Hapus Akun -->
    <div class="col-lg-12 mb-4">
        <div class="card product-card">
            <div class="card-body">
                <h5 class="card-title text-danger"><i class="fas fa-trash-alt me-2"></i> Hapus Akun</h5>
                <hr>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.</p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
