<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRecord extends Model
{
    protected $fillable = [
        'name',
        'forwarded',
        'position',
        'school',
        'type_of_leave',
        'inclusive_dates',
        'remarks',
        'date_of_action',
        'deduction_remarks',
        'incharge',
        'is_processed',
        'batch_id',
    ];
}
