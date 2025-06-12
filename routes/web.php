<?php

use App\Http\Controllers\{
    Auth\AuthenticatedSessionController,
    Auth\AdminLoginController,
    Auth\UserLoginController,
    HomeController,
    OrderController,
    ProductController,
    ProfileController,
    SocialiteController,
    WishlistController,
    ReviewController
};
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

// ====================
// Home Route         
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ====================
// USER Login Group
// ====================

Route::middleware('guest')->group(function () {
    Route::get('/user/login', [AuthenticatedSessionController::class, 'create'])
        ->defaults('guard', 'web')
        ->name('user.login');

    Route::post('/user/login', [AuthenticatedSessionController::class, 'store'])
        ->defaults('guard', 'web')
        ->name('user.login.post');
});

// ====================
// ADMIN Login Group
// ====================
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
        ->defaults('guard', 'admin')
        ->name('admin.login');

    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
        ->defaults('guard', 'admin')
        ->name('admin.login.post');
});

// Logout (admin dan user)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// ======================
// Admin Protected Routes
// ======================
Route::middleware(['auth:admin', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// ==============================
// Google OAuth Login for Users
// ==============================
Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google', 'googleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

// ======================================
// User Protected Routes (Profile, etc.)
// ======================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

    // Review
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

    // Balasan ulasan
    // Route::post('/reviews/{review}/reply', [ReviewController::class, 'storeReply'])->name('reviews.reply')->middleware('auth');

// ====================
// Order Routes
// ====================
Route::get('/order/wishlist', [OrderController::class, 'fromWishlist'])->name('order.wishlist');

// ====================
// Product Management
// ====================
Route::resource('products', ProductController::class)->except(['show']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ========================
// Custom Pages (if needed)
// ========================
Route::get('/akun', [ProductController::class, 'index'])->name('products.index');

// ==========================
// Breeze Default Auth Routes
// ==========================

require __DIR__.'/auth.php';
