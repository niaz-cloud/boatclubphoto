<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('backend.admin.auth.login');
    }

    /**
 /**
     * ✅ Login Method (Spatie-safe)
     */
    public function login(Request $request)
    {
        // ✅ Validate request
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required', 'string'],
            'not_robot' => ['accepted'],
        ]);

        // Remove checkbox field
        unset($credentials['not_robot']);

        // ✅ Attempt login
        if (Auth::attempt($credentials)) {

            // Regenerate session
            $request->session()->regenerate();

            $user = Auth::user();

            // =============================
            // ROLE BASED REDIRECT
            // =============================

            // Admin
            if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
                return redirect()
                    ->route('admin.dashboard')
                    ->with('success', 'Login successful');
            }

            // Teacher
            if ($user->hasRole('Teacher')) {
                return redirect()
                    ->route('teacher.dashboard')
                    ->with('success', 'Welcome Teacher');
            }

            // Student
            if ($user->hasRole('Student')) {
                return redirect()
                    ->route('student.dashboard')
                    ->with('success', 'Welcome Student');
            }

            // 🚨 Unknown role
            Auth::logout();
            abort(403, 'Unauthorized role access.');
        }

        // ❌ Login failed
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password');
    }
    /**
     * ✅ Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
