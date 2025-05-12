<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Redirect to Google
    public function googleLogin() {
        return Socialite::driver('google')->redirect();
    }

    // Authentication user 
    public function googleAuthentication() {
        $googleUser = Socialite::driver('google')->user();

        dd($googleUser);
    }
 }
