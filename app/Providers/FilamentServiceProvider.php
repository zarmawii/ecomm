<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Models\User;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Restrict Filament admin access to users with is_admin = true
        Filament::serving(function () {
            Filament::auth(function (User $user): bool {
                return $user->is_admin;
            });
        });

        // Optional: organize admin navigation
        Filament::registerNavigationGroups([
            // 'Products', 'Orders', etc.
        ]);
    }
}