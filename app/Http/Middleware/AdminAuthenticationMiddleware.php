<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Not logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // ✅ If user_type field doesn't exist OR user is not admin
        if (!isset($user->user_type) || $user->user_type !== 'admin') {

            // Optional: logout non-admin user
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Unauthorized access. Admin login required.');
        }

        return $next($request);
    }
}
