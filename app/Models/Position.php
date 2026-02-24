<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'employee_name',
        'school',
        'type_of_leave',
        'inclusive_dates',
        'remarks',
        'date_of_action',
        'deduction_remarks',
    ];

    public function leaveRecords()
    {
        return $this->hasMany(LeaveRecord::class, 'position', 'name');
    }
}
