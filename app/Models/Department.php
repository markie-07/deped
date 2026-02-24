<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'employee_name',
        'position',
        'school',
        'type_of_leave',
        'inclusive_dates',
        'date_of_action',
        'deduction_remarks',
    ];

    public function leaveRecords()
    {
        return $this->hasMany(LeaveRecord::class, 'department', 'name');
    }
}
