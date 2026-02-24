<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Populate Schools with latest record info
        $schools = \App\Models\LeaveRecord::select('school')
            ->distinct()
            ->whereNotNull('school')
            ->where('school', '!=', '')
            ->pluck('school');

        foreach ($schools as $school) {
            $latest = \App\Models\LeaveRecord::where('school', $school)
                ->orderBy('created_at', 'desc')
                ->first();

            $type = 'Other';
            $lower = strtolower($school);
            if (str_contains($lower, 'high school') || str_contains($lower, 'secondary') || preg_match('/\bhs\b/', $lower)) {
                $type = 'High School';
            } elseif (str_contains($lower, 'integrated')) {
                $type = 'Integrated';
            } elseif (str_contains($lower, 'elementary') || preg_match('/\bes\b/', $lower)) {
                $type = 'Elementary';
            }

            \App\Models\School::updateOrCreate(
                ['name' => $school],
                [
                    'type' => $type,
                    'employee_name' => $latest->name ?? null,
                    'position' => $latest->position ?? null,
                    'type_of_leave' => $latest->type_of_leave ?? null,
                    'inclusive_dates' => $latest->inclusive_dates ?? null,
                    'remarks' => $latest->remarks ?? null,
                    'date_of_action' => $latest->date_of_action ?? null,
                    'deduction_remarks' => $latest->deduction_remarks ?? null,
                ]
            );
        }

        // Populate Positions with latest record info
        $positions = \App\Models\LeaveRecord::select('position')
            ->distinct()
            ->whereNotNull('position')
            ->where('position', '!=', '')
            ->pluck('position');

        foreach ($positions as $position) {
            $latest = \App\Models\LeaveRecord::where('position', $position)
                ->orderBy('created_at', 'desc')
                ->first();

            \App\Models\Position::updateOrCreate(
                ['name' => $position],
                [
                    'employee_name' => $latest->name ?? null,
                    'school' => $latest->school ?? null,
                    'type_of_leave' => $latest->type_of_leave ?? null,
                    'inclusive_dates' => $latest->inclusive_dates ?? null,
                    'remarks' => $latest->remarks ?? null,
                    'date_of_action' => $latest->date_of_action ?? null,
                    'deduction_remarks' => $latest->deduction_remarks ?? null,
                ]
            );
        }

        // Populate Leave Types with latest record info
        $leaveTypes = \App\Models\LeaveRecord::select('type_of_leave')
            ->distinct()
            ->whereNotNull('type_of_leave')
            ->where('type_of_leave', '!=', '')
            ->pluck('type_of_leave');

        foreach ($leaveTypes as $leaveType) {
            $latest = \App\Models\LeaveRecord::where('type_of_leave', $leaveType)
                ->orderBy('created_at', 'desc')
                ->first();

            \App\Models\LeaveType::updateOrCreate(
                ['name' => $leaveType],
                [
                    'employee_name' => $latest->name ?? null,
                    'position' => $latest->position ?? null,
                    'school' => $latest->school ?? null,
                    'inclusive_dates' => $latest->inclusive_dates ?? null,
                    'remarks' => $latest->remarks ?? null,
                    'date_of_action' => $latest->date_of_action ?? null,
                    'deduction_remarks' => $latest->deduction_remarks ?? null,
                ]
            );
        }

        // Populate Remarks with latest record info
        $remarks = \App\Models\LeaveRecord::select('remarks')
            ->distinct()
            ->whereNotNull('remarks')
            ->where('remarks', '!=', '')
            ->pluck('remarks');

        foreach ($remarks as $remark) {
            $latest = \App\Models\LeaveRecord::where('remarks', $remark)
                ->orderBy('created_at', 'desc')
                ->first();

            \App\Models\Remark::updateOrCreate(
                ['name' => $remark],
                [
                    'employee_name' => $latest->name ?? null,
                    'position' => $latest->position ?? null,
                    'school' => $latest->school ?? null,
                    'type_of_leave' => $latest->type_of_leave ?? null,
                    'inclusive_dates' => $latest->inclusive_dates ?? null,
                    'date_of_action' => $latest->date_of_action ?? null,
                    'deduction_remarks' => $latest->deduction_remarks ?? null,
                ]
            );
        }

        // Populate Departments with latest record info
        $departments = \App\Models\LeaveRecord::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->pluck('department');

        foreach ($departments as $dept) {
            $latest = \App\Models\LeaveRecord::where('department', $dept)
                ->orderBy('created_at', 'desc')
                ->first();

            \App\Models\Department::updateOrCreate(
                ['name' => $dept],
                [
                    'employee_name' => $latest->name ?? null,
                    'position' => $latest->position ?? null,
                    'school' => $latest->school ?? null,
                    'type_of_leave' => $latest->type_of_leave ?? null,
                    'inclusive_dates' => $latest->inclusive_dates ?? null,
                    'date_of_action' => $latest->date_of_action ?? null,
                    'deduction_remarks' => $latest->deduction_remarks ?? null,
                ]
            );
        }
    }
}
