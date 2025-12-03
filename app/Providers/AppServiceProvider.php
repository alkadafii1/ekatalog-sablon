<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    View::composer('*', function ($view) {
        $wishlistCount = 0;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // Hanya hitung wishlist jika benar-benar instance User, bukan Admin
            if ($user instanceof \App\Models\User) {
                $wishlistCount = $user->wishes()->count();
            }
        }

        $view->with('wishlistCount', $wishlistCount);
    });
}



}
