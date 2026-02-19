<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    /**
     * ✅ Admin List
     */
    public function index()
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Admin List';

        $admins = User::where('role', 'admin')
            ->latest()
            ->get();

        return view(
            'backend.admin.admins.admin_index',
            compact('data', 'admins')
        );
    }

    /**
     * ✅ Admin Details
     */
    public function show(User $admin)
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Admin Details';

        return view(
            'backend.admin.admins.admin_show',
            compact('admin', 'data')
        );
    }

    /**
     * ✅ Create Admin Form
     */
    public function create()
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Add Admin';

        return view(
            'backend.admin.admins.admin_create',
            compact('data')
        );
    }

    /**
     * ✅ Store Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $admin = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'admin',
        ]);

        // ✅ Assign Spatie role
        $admin->assignRole('admin');

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin created successfully');
    }

    /**
     * ✅ Edit Admin Form
     */
    public function edit(User $admin)
    {
        $data['active_menu'] = 'admins';
        $data['page_title']  = 'Edit Admin';

        $roles = Role::orderBy('name')->get();

        return view(
            'backend.admin.admins.admin_edit',
            compact('admin', 'roles', 'data')
        );
    }

    /**
     * ✅ Update Admin
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role'  => 'required'
        ]);

        // ✅ Update basic info
        $admin->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // ✅ Sync Spatie role
        $admin->syncRoles([$request->role]);

        return back()->with('success', 'Admin updated successfully.');
    }

    /**
     * ✅ Delete Admin
     */
    public function destroy(User $admin)
    {
        // 🚫 Prevent deleting yourself
        if (auth()->id() === $admin->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }

    /**
     * ✅ Reset Password
     */
    public function resetPassword(Request $request, User $admin)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password reset successfully.');
    }
}
