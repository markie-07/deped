<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'type',
        'employee_name',
        'position',
        'type_of_leave',
        'inclusive_dates',
        'remarks',
        'date_of_action',
        'deduction_remarks',
    ];

    public function leaveRecords()
    {
        return $this->hasMany(LeaveRecord::class, 'school', 'name');
    }
}

