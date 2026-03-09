<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;

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
        // Share cart count with all views
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            }

            $view->with('cartCount', $cartCount);
        });

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Auto-create Render admin if it doesn't exist
        if (!User::where('email', 'admin@render.com')->exists()) {
            User::create([
                'name' => 'Render Admin',
                'email' => 'admin@render.com',
                'password' => Hash::make('password123'), // change to strong password
                'is_admin' => true,
            ]);
        }

        // Restrict Filament access to admin users
        Filament::serving(function () {
            Filament::auth(function (User $user): bool {
                return $user->is_admin;
            });
        });
    }
}