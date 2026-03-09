<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Block admin panel in production
        Filament::serving(function () {
            if (!app()->environment('local')) {
                abort(403, 'Admin panel is only available locally.');
            }
        });
    }

    public function register(): void
    {
        //
    }
}