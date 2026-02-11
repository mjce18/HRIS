<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hris.com',
            'password' => Hash::make('Admin@2024'),
            'employee_id' => 'EMP001',
            'status' => 'active',
            'account_activated' => true,
        ]);
        $admin->assignRole('super-admin');

        Employee::create([
            'user_id' => $admin->id,
            'employee_code' => 'EMP001',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'department_id' => 1,
            'position_id' => 1,
            'hire_date' => now(),
            'employment_type' => 'full-time',
            'salary' => 100000,
        ]);

        $hr = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@hris.com',
            'password' => Hash::make('HR@2024'),
            'employee_id' => 'EMP002',
            'status' => 'active',
            'account_activated' => true,
        ]);
        $hr->assignRole('hr');

        Employee::create([
            'user_id' => $hr->id,
            'employee_code' => 'EMP002',
            'first_name' => 'HR',
            'last_name' => 'Manager',
            'department_id' => 1,
            'position_id' => 2,
            'hire_date' => now(),
            'employment_type' => 'full-time',
            'salary' => 60000,
        ]);

        $employee = User::create([
            'name' => 'John Doe',
            'email' => 'employee@hris.com',
            'password' => Hash::make('Employee@2024'),
            'employee_id' => 'EMP003',
            'status' => 'active',
            'account_activated' => true,
        ]);
        $employee->assignRole('employee');

        Employee::create([
            'user_id' => $employee->id,
            'employee_code' => 'EMP003',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'department_id' => 2,
            'position_id' => 4,
            'hire_date' => now()->subMonths(6),
            'employment_type' => 'full-time',
            'salary' => 50000,
        ]);
    }
}
