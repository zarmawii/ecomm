<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Seller;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SellerLoginController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RazorpayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --------------------
// Home Page
// --------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');

// --------------------
// Guest Routes (Normal User)
// --------------------


// --------------------
// Normal User Routes (Authenticated)
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --------------------
// Seller Public Pages
// --------------------
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/', function () {
        return view('seller.index');
    })->name('index');

    Route::get('/register', function () {
        return view('seller.register');
    })->name('register');

    Route::post('/register', [SellerRegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [SellerLoginController::class, 'create'])->name('login');
    Route::post('/login', [SellerLoginController::class, 'store'])->name('login.store');
});

// --------------------
// Seller Protected Routes
// --------------------
Route::middleware(['auth:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $seller = auth('seller')->user();
        abort_unless($seller && $seller->is_verified, 403);
        return view('seller.dashboard');
    })->name('dashboard');

    Route::post('/logout', [SellerLoginController::class, 'destroy'])->name('logout');

    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
});

// --------------------
// Cart Routes (Only Logged-in Users)
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    
    Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
});
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/buy-now/{product}', [CartController::class, 'buyNow'])->name('buy.now');
// --------------------
// Default Auth Routes (Users)
// --------------------
require __DIR__ . '/auth.php';

// --------------------
// Razorpay Payment Routes
// --------------------
// Note: Removed 'auth' middleware so Razorpay callback works even if session is slightly lost
Route::get('/razorpay', [RazorpayController::class, 'index']);
Route::post('/razorpay/payment', [RazorpayController::class, 'payment'])->name('razorpay.payment');
Route::post('/razorpay/success', [RazorpayController::class, 'success'])->name('razorpay.success');
 //seller otp
 Route::get('/seller/otp', [SellerLoginController::class, 'showOtpForm'])
    ->name('seller.otp.form');

Route::post('/seller/otp', [SellerLoginController::class, 'verifyOtp'])
    ->name('seller.otp.verify');