<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'name',
        'employee_name',
        'position',
        'school',
        'inclusive_dates',
        'remarks',
        'date_of_action',
        'deduction_remarks',
    ];

    public function leaveRecords()
    {
        return $this->hasMany(LeaveRecord::class, 'type_of_leave', 'name');
    }
}
