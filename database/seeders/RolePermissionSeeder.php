<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view employees',
            'create employees',
            'edit employees',
            'delete employees',
            'view attendance',
            'manage attendance',
            'view leaves',
            'create leaves',
            'approve leaves',
            'view departments',
            'manage departments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin = Role::create(['name' => 'super-admin']);
        
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view employees',
            'create employees',
            'edit employees',
            'view attendance',
            'manage attendance',
            'view leaves',
            'approve leaves',
            'view departments',
        ]);

        $hr = Role::create(['name' => 'hr']);
        $hr->givePermissionTo([
            'view employees',
            'create employees',
            'edit employees',
            'view attendance',
            'manage attendance',
            'view leaves',
            'approve leaves',
        ]);

        $employee = Role::create(['name' => 'employee']);
        $employee->givePermissionTo([
            'view attendance',
            'view leaves',
            'create leaves',
        ]);
    }
}
