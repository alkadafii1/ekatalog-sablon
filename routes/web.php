<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


// USER LOGIN
Route::get('/user/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest:web')
    ->name('user.login')
    ->defaults('guard', 'web');

Route::post('/user/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest:web')
    ->name('user.login.post')
    ->defaults('guard', 'web');

// ADMIN LOGIN
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest:admin')
    ->name('admin.login')
    ->defaults('guard', 'admin');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest:admin')
    ->name('admin.login.post')
    ->defaults('guard', 'admin');

// ADMIN DASHBOARD (hanya untuk admin)
Route::middleware(['auth:admin', 'checkRole:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


// LOGIN USER (pakai Google)
// Route::middleware('guest:web')->group(function () {
//     Route::get('/user/login', function () {
//         return view('auth.user-login');
//     })->name('user.login');
// });

Route::controller(SocialiteController::class)->group(function() {
Route::get('auth/google', 'googleLogin')->name('auth.google');
Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Wishlist
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

require __DIR__.'/auth.php';

// Manajemen Produk
Route::resource('products', ProductController::class);
// Daftar Produk - Menampilkan semua produk + fitur pencarian
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Tambah Produk - Menampilkan form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Simpan Produk - Menyimpan produk yang ditambahkan
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Edit Produk - Menampilkan form edit produk
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Update Produk - Menyimpan perubahan produk
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
// Hapus Produk - Menghapus produk
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Show Produk - Melihat jumlah kunjungan
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Show Produk - Melihat jumlah kunjungan
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');;


