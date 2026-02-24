<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'department',
        'position',
        'school',
        'type_of_leave',
        'inclusive_dates',
        'remarks',
        'date_of_action',
        'deduction_remarks',
        'incharge',
    ];
}
