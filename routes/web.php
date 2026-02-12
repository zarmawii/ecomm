<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SellerLoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Seller;
use App\Http\Controllers\RazorpayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider.
|
*/

// ---------------------
// Public Routes
// ---------------------

Route::get('/', function () {
    return view('welcome');
});

// ---------------------
// Regular User Routes
// ---------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------
// Seller Routes
// ---------------------

// Seller Dashboard (only verified sellers)
Route::middleware(['auth:seller'])->group(function () {
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

// Seller Landing Page
Route::get('/seller', function () {
    return view('seller.index');
})->name('seller.auth');

// Seller Registration
Route::get('/seller/register', function () {
    return view('seller.register');
})->name('seller.register');

Route::post('/seller/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:sellers,email',
        'password' => 'required|confirmed|min:6',
    ]);

    \App\Models\Seller::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'is_verified' => false,
    ]);

    return redirect()->route('seller.login')
        ->with('success', 'Registration complete! Wait for admin verification.');
})->name('seller.register.store');

// Seller Login
Route::get('/seller/login', [SellerLoginController::class, 'create'])->name('seller.login');
Route::post('/seller/login', [SellerLoginController::class, 'store'])->name('seller.login.store');

// ---------------------
// Include default auth routes for regular users
// ---------------------
Route::post('/seller/logout', [SellerLoginController::class, 'destroy'])
    ->name('seller.logout');
require __DIR__.'/auth.php';



Route::get('/razorpay', [RazorpayController::class, 'index']);
Route::post('/razorpay/payment', [RazorpayController::class, 'payment'])->name('razorpay.payment');
Route::post('/razorpay/success', [RazorpayController::class, 'success'])->name('razorpay.success');