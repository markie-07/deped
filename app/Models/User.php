<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'position',
        'profile_image',
        'profile_offset_x',
        'profile_offset_y',
        'profile_zoom',
        'cover_image',
        'cover_offset_x',
        'cover_offset_y',
        'cover_zoom',
        'face_descriptor',
        'face_attempts',
        'face_locked_until',
        'email',
        'password',
        'is_active',
        'is_approved',
        'role',
        'assigned',
        'email_hash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email' => 'encrypted',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_approved' => 'boolean',
            'face_descriptor' => 'encrypted:json',
            'face_locked_until' => 'datetime',
            'profile_image' => 'encrypted',
            'cover_image' => 'encrypted',
        ];
    }
    /**
     * Boot the model to handle automatic email hashing.
     */
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('email')) {
                // Generate a blind index hash for encrypted email lookup
                $user->email_hash = hash('sha256', strtolower($user->email));
            }
        });
    }

}
