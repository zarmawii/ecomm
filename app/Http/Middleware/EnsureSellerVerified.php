<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/EnsureSellerVerified.php
public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'seller') {
        if (auth()->user()->status !== 'verified') {
            auth()->logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Your seller account is not verified yet.'
                ]);
        }
    }

    return $next($request);
}

}
