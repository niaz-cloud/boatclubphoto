<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    /**
     * Show admin list
     */
    public function index()
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Admin List';

        $admins = User::where('role', 'admin')->latest()->get();

        // 🔧 FIXED VIEW NAME
        return view('backend.admin.admins.admin_index', compact('data', 'admins'));
    }

    /**
     * Show create admin form
     */
    public function create()
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Add Admin';

        // 🔧 FIXED VIEW NAME
        return view('backend.admin.admins.admin_create', compact('data'));
    }

    /**
     * Store admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'admin',
        ]);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin created successfully');
    }
}
