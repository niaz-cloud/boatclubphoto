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
     * Updated login method
     */
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'      => ['required', 'email'],
        'password'   => ['required', 'string'],
        'not_robot'  => ['accepted'], // ✅ match login blade checkbox
    ]);

    // remove checkbox from credentials before Auth::attempt
    unset($credentials['not_robot']);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Login successful');
    }

    return back()
        ->withInput($request->only('email'))
        ->with('error', 'Invalid email or password');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}