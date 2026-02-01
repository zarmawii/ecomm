<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerLoginController extends Controller
{
    public function create()
    {
        return view('seller.login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    if (Auth::guard('seller')->attempt([
        'email' => $credentials['email'],
        'password' => $credentials['password'],
        'is_verified' => true, // only verified sellers
    ], $request->filled('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended('/seller/dashboard');
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records or your account is not verified.',
    ]);
}


    public function destroy(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/seller/login')->with('success', 'Logged out successfully.');;
    }
}
