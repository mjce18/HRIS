<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'code' => 'AL', 'days_allowed' => 15],
            ['name' => 'Sick Leave', 'code' => 'SL', 'days_allowed' => 10],
            ['name' => 'Casual Leave', 'code' => 'CL', 'days_allowed' => 5],
            ['name' => 'Maternity Leave', 'code' => 'ML', 'days_allowed' => 90],
            ['name' => 'Paternity Leave', 'code' => 'PL', 'days_allowed' => 7],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::create($leaveType);
        }
    }
}
