<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        // return Socialite::driver('google')->redirect();
        // return Socialite::driver('google')->stateless()->redirect();
{
    return Socialite::driver('google')->with(['prompt' => 'consent select_account'])->redirect();
}   
    }

    public function callback()
    {
        // $googleUser = Socialite::driver('google')->user();
        $googleUser = Socialite::driver('google')->stateless()->user();


        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'password' => bcrypt(str()->random(16))
            ]
        );

        Auth::login($user);
        // return redirect('/dashboard');
        session(['pin_verified' => false]);
        return redirect()->route('pin.form');
    }
    
}