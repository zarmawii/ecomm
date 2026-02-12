<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // If no guard passed, default to 'web' (normal users)
        $guards = empty($guards) ? ['web'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on guard
                switch ($guard) {
                    case 'seller':
                        return redirect()->route('seller.dashboard');
                    case 'web':
                    default:
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
