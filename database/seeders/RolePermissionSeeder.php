<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // ----------------------
        // Permissions
        // ----------------------
        $permissions = [
            // Student
            'view student',
            'create student',
            'edit student',
            'delete student',

            // Class
            'view class',
            'create class',
            'edit class',
            'delete class',

            // Exam
            'view exam',
            'create exam',
            'publish result',

            // Reports
            'view report',
            'export report',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ----------------------
        // Roles (FIXED)
        // ----------------------
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);

        // ----------------------
        // Assign Permissions
        // ----------------------
        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'view student',
            'create student',
            'edit student',

            'view class',
            'view exam',
            'view report',
        ]);
    }
}
