<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1️⃣ User must be logged in
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login first.');
        }

        // 2️⃣ Only allow super_admin or admin
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }

        // 3️⃣ Access granted
        return $next($request);
    }
}
