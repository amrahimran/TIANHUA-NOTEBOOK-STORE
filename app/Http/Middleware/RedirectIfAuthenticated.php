<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Redirect based on role
            return Auth::user()->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/dashboard');
        }

        return $next($request);
    }
}
