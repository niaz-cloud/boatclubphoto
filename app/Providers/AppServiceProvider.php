<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // ✅ ADD THIS

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔐 Admin Login Rate Limiter
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->ip() . '|' . $request->input('email')
            );
        });

        // 👑 Super Admin Bypass Permissions ✅ ADD THIS BLOCK
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
