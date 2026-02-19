<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    /**
     * Role list page
     */
    public function index()
    {
        $data = [];
        $data['active_menu'] = 'role_permissions';
        $data['page_title']  = 'Role Permission Management';

        $roles = Role::orderBy('name')->get();

        return view(
            'backend.admin.role_permissions.role_permission_index',
            compact('roles', 'data')
        );
    }

    /**
     * Edit permissions for role
     */
    public function edit(Role $role)
    {
        $data = [];
        $data['active_menu'] = 'role_permissions';
        $data['page_title']  = 'Manage Role Permissions';

        $permissions = Permission::orderBy('name')->get();

        // ✅ Group permissions by module
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[1] ?? 'other';
        });

        // ✅ Current role permissions
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view(
            'backend.admin.role_permissions.role_permission_edit',
            compact('role', 'groupedPermissions', 'rolePermissions', 'data')
        );
    }

    /**
     * Update role permissions
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
        ]);

        $permissions = $request->permissions ?? [];

        // ✅ Sync permissions
        $role->syncPermissions($permissions);

        // ✅ VERY IMPORTANT (Spatie cache)
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permissions updated successfully.');
    }
}
