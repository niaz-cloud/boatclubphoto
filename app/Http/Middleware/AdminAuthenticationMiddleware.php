<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
{
    if (!Auth::guard('web')->check()) {
        return redirect()->route('admin.login');
    }

    $user = Auth::guard('web')->user();

    if (!$user->hasAnyRole(['Super Admin', 'Admin'])) {
        abort(403, 'Unauthorized access.');
    }

    return $next($request);
}
}