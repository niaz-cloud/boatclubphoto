<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BackendAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ If logged in, allow
        if (Auth::check()) {
            return $next($request);
        }

        // ✅ If this is admin area, send to admin login
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->route('admin.login');
        }

        // ✅ Otherwise normal user login route
        return redirect()->route('login');
    }
}
