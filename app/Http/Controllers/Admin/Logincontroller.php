<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Notifications\AdminLoginLink;
// use Illuminate\Support\Facades\Notification;
// use Illuminate\Support\Facades\Hash;

class Logincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
       return view('admin.login');
    }
    public function showLogin()
    {
        // Already logged in → go directly to dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
 
        return view('admin.login');
        // dd("This is testing route for admin login page");
    }
    public function index1(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);
 
    // ── Rate limiting: max 5 failed attempts per minute ──────────────
        $throttleKey = 'admin-login:' . $request->ip();
 
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => "Too many login attempts. Please wait {$seconds} seconds and try again.",
                ]);
        }
 
    // Set ADMIN_EMAIL=owner@awadhbuildmate.com in your .env file
        $ownerEmail = env('ADMIN_EMAIL', 'owner@awadhbuildmate.com');
        $ownerEmail2 = env('ADMIN_EMAIL2', 'shivani30@gmail.com');
 
        if ($request->email !== $ownerEmail && $request->email !== $ownerEmail2) {
            RateLimiter::hit($throttleKey, 60);
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Access denied. Only the site owner can log in.',
                ]);
        }
 
    //     // ── Attempt authentication ───────────────────────────────────────
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');
 
        if (Auth::attempt($credentials, $remember)) {
            // Success — clear rate limiter and regenerate session
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
 
            return redirect()->route('admin.dashboard')
                ->with('success');
        }
     // ── Failed authentication ───────//
        RateLimiter::hit($throttleKey, 60);
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Invalid email or password.',
            ]);
    }
   public function sendMagicLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $throttleKey = 'magic-link:' . $request->ip();
 
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withInput()
                ->withErrors(['email' => "Too many requests. Wait {$seconds} seconds."]);
        }
 
        RateLimiter::hit($throttleKey, 60);
 
        $ownerEmail = env('ADMIN_EMAIL', 'owner@awadhbuildmate.com');
 
        // Always return success page — don't reveal if email matches
        if ($request->email === $ownerEmail) {
            $user = User::where('email', $ownerEmail)->first();
 
            if ($user) {
                // Create a secure one-time token valid for 15 minutes
                $token = Str::random(64);
                Cache::put('admin_magic_' . $token, $user->id, now()->addMinutes(15));
 
                // Send the email
                $user->notify(new AdminLoginLink($token));
            }
        }
 
        // Always show this — security: never confirm if email is valid
        return back()->with('magic_sent', true);
    }
 
    // ── Verify magic link and log in ─────────────────────────────────────//
    public function verifyMagicLink(Request $request, string $token)
    {
        $userId = Cache::get('admin_magic_' . $token);
 
        if (!$userId) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'This login link has expired or already been used. Please request a new one.']);
        }
 
        $user = User::find($userId);
 
        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Account not found.']);
        }
 
        // Delete token — one-time use only
        Cache::forget('admin_magic_' . $token);
 
        Auth::login($user, true);
        $request->session()->regenerate();
 
        return redirect()->route('admin.dashboard')
            ->with('success', 'Signed in via email link. Welcome back, ' . $user->name . '!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
        // dd('Checking logout functionality');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
