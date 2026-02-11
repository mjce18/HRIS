<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

// Get the first employee (or you can specify employee ID)
$employee = Employee::first();

if (!$employee) {
    echo "No employee found!\n";
    exit;
}

echo "Resetting absences for: {$employee->first_name} {$employee->last_name}\n";

$startDate = Carbon::now()->startOfMonth();
$endDate = Carbon::now();
$currentDate = $startDate->copy();

$created = 0;

while ($currentDate <= $endDate) {
    // Skip weekends (Saturday = 6, Sunday = 0)
    if ($currentDate->dayOfWeek != 0 && $currentDate->dayOfWeek != 6) {
        $exists = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $currentDate)
            ->exists();
        
        if (!$exists) {
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $currentDate->format('Y-m-d'),
                'check_in' => $currentDate->copy()->setTime(9, 0, 0),
                'check_out' => $currentDate->copy()->setTime(17, 0, 0),
                'status' => 'present',
            ]);
            $created++;
            echo "Created attendance for: {$currentDate->format('Y-m-d')}\n";
        }
    }
    $currentDate->addDay();
}

echo "\nDone! Created {$created} attendance records.\n";
echo "Absences should now be 0.\n";
