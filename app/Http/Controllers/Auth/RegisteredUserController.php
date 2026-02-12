<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    // Show registration form
    public function create()
    {
        return view('auth.register'); // make sure resources/views/auth/register.blade.php exists
    }

    // Handle registration
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ⚠️ Optional: comment out auto-login
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Account created! Please log in.');
    }
}
