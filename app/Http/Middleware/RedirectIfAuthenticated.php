<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
      foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Redirect berdasarkan role
            $user = Auth::guard($guard)->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }
    }

    return $next($request);
}
}
