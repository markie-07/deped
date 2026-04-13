<?php

use App\Models\LeaveRecord;
use App\Models\School;
use App\Models\Position;
use App\Models\LeaveType;
use App\Models\Remark;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting rebuild of lookup tables...\n";

// Clear existing tables
echo "Clearing lookup tables...\n";
School::truncate();
Position::truncate();
LeaveType::truncate();
Remark::truncate();
Employee::truncate();

$records = LeaveRecord::all();
echo "Processing " . $records->count() . " records...\n";

foreach ($records as $record) {
    // 1. Sync Employee
    Employee::create([
        'name' => $record->name,
        'forwarded' => $record->forwarded,
        'position' => $record->position,
        'school' => $record->school,
        'type_of_leave' => $record->type_of_leave,
        'inclusive_dates' => $record->inclusive_dates,
        'remarks' => $record->remarks,
        'date_of_action' => $record->date_of_action,
        'deduction_remarks' => $record->deduction_remarks,
        'assigned' => $record->assigned,
        'user_id' => $record->user_id,
        'incharge' => $record->incharge,
    ]);

    // 2. Sync School
    if ($record->school) {
        $type = 'Other';
        $lower = strtolower($record->school);
        if (str_contains($lower, 'high school') || str_contains($lower, 'secondary') || preg_match('/\bhs\b/', $lower)) {
            $type = 'High School';
        } elseif (str_contains($lower, 'integrated')) {
            $type = 'Integrated';
        } elseif (str_contains($lower, 'elementary') || preg_match('/\bes\b/', $lower)) {
            $type = 'Elementary';
        }
        School::updateOrCreate(
            ['name' => $record->school],
            [
                'type' => $type,
                'employee_name' => $record->name,
                'position' => $record->position,
                'type_of_leave' => $record->type_of_leave,
                'inclusive_dates' => $record->inclusive_dates,
                'remarks' => $record->remarks,
                'date_of_action' => $record->date_of_action,
                'deduction_remarks' => $record->deduction_remarks,
                'assigned' => $record->assigned,
            ]
        );
    }

    // 3. Sync Position
    if ($record->position) {
        Position::updateOrCreate(
            ['name' => $record->position],
            [
                'employee_name' => $record->name,
                'school' => $record->school,
                'type_of_leave' => $record->type_of_leave,
                'inclusive_dates' => $record->inclusive_dates,
                'remarks' => $record->remarks,
                'date_of_action' => $record->date_of_action,
                'deduction_remarks' => $record->deduction_remarks,
                'assigned' => $record->assigned,
            ]
        );
    }

    // 4. Sync Leave Type
    if ($record->type_of_leave) {
        $types = explode(', ', $record->type_of_leave);
        foreach ($types as $lt) {
            LeaveType::updateOrCreate(
                ['name' => trim($lt)],
                [
                    'employee_name' => $record->name,
                    'position' => $record->position,
                    'school' => $record->school,
                    'inclusive_dates' => $record->inclusive_dates,
                    'remarks' => $record->remarks,
                    'date_of_action' => $record->date_of_action,
                    'deduction_remarks' => $record->deduction_remarks,
                    'assigned' => $record->assigned,
                ]
            );
        }
    }

    // 5. Sync Remark
    if ($record->remarks) {
        Remark::updateOrCreate(
            ['name' => $record->remarks],
            [
                'employee_name' => $record->name,
                'position' => $record->position,
                'school' => $record->school,
                'type_of_leave' => $record->type_of_leave,
                'inclusive_dates' => $record->inclusive_dates,
                'date_of_action' => $record->date_of_action,
                'deduction_remarks' => $record->deduction_remarks,
                'assigned' => $record->assigned,
            ]
        );
    }
}

echo "Rebuild complete!\n";
