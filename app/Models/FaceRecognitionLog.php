<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FaceRecognitionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distance',
        'confidence',
        'status',
        'attempt_image',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'json',
        'distance' => 'encrypted',
        'confidence' => 'encrypted',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
