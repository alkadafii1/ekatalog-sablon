<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\{
    DashboardController,
    // Auth\AuthenticatedSessionController,
    Auth\GoogleLoginController,
    Auth\AdminLoginController,
    Auth\UserLoginController,
    HomeController,
    OrderController,
    ProductController,
    ProfileController,
    // SocialiteController,
    WishlistController,
    ReviewController,
    ReplyController,
    SaleController
};
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

// ====================
// Home Route         
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ====================
// USER Login Group
// ====================
Route::get('/login', [UserLoginController::class, 'showLoginForm'])
    ->name('user.login');       

Route::post('/login', [UserLoginController::class, 'login'])
    ->name('user.login.post'); 

Route::post('/logout', [UserLoginController::class, 'logout'])
    ->name('user.logout');

// ====================
// ADMIN Login Group
// ====================

Route::middleware(['auth:admin'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::prefix('admin')->group(function () {
    // Login Admin
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Route yang butuh autentikasi admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

// ==============================
// Google OAuth Login for Users
// ==============================

Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


// ======================================
// User Protected Routes (Profile, etc.)
// ======================================
Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

    // Review
    // Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews')->middleware('auth');

    // Halaman ulasan toko
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // Menyimpan ulasan
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/reviews/{review}/like', [ReviewController::class, 'likeReview'])->name('reviews.like');

    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


    // Menyimpan balasan terhadap ulasan
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'storeReply'])->name('reviews.reply');

    // Reply Routes
    Route::post('/reviews/{review}/replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::post('/replies/{reply}/like', [ReplyController::class, 'like'])->name('replies.like');
    Route::put('/replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

// ====================
// Order Routes
// ====================
Route::get('/order/wishlist', [OrderController::class, 'fromWishlist'])->name('order.wishlist');
Route::post('/order/from-wishlist', [OrderController::class, 'fromWishlist'])->name('order.from-wishlist');

// ====================
// Laporan keuangan Routes
// ====================
Route::get('sales/report', [SaleController::class, 'report'])->name('sales.report');
Route::resource('sales', SaleController::class);

// ====================
// Product Management
// ====================

Route::get('/manajemen', [ProductController::class, 'index'])->name('products.index');
Route::resource('products', ProductController::class)->except(['show']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/produk-teratas', [HomeController::class, 'topProducts'])->name('top.products');
Route::get('/kategori/{kategori}', [HomeController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/kategori/{kategori}', [ProductController::class, 'byCategory'])->name('products.byCategory');


// ==========================
// Breeze Default Auth Routes
// ==========================

//use App\Http\Middleware\EnsureUserIsAdmin;

// ====================
// Admin Area
// ====================
// Route::middleware(['auth:admin', AdminAuth::class])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])
//             ->name('dashboard');
//     });

// ====================
// User Area
// ====================
// Route::middleware(['auth:web'])
//     ->group(function () {
//         Route::get('/', [HomeController::class, 'index'])
//             ->name('home');
//     });



require __DIR__.'/auth.php';
