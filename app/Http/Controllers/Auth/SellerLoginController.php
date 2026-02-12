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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('seller')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_verified' => true,
        ], $request->filled('remember'))) {
            $request->session()->regenerate();

            // ✅ Check immediately
            // dd(auth('seller')->check(), auth('seller')->id());

            return redirect()->route('seller.dashboard')
                             ->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'Credentials do not match or account not verified.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')
                         ->with('success', 'Logged out successfully.');
    }
}
