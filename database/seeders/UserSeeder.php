<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'markjamesp11770@gmail.com';
        $emailHash = hash('sha256', strtolower($email));

        // 1. Main Admin Account - Use email_hash for unique lookup
        User::updateOrCreate(
            ['email_hash' => $emailHash],
            [
                'email' => $email,
                'name' => 'Mark James Gabriel Pisngot',
                'first_name' => 'Mark James',
                'last_name' => 'Pisngot',
                'middle_name' => 'Gabriel',
                'position' => 'ADMIN',
                'role' => 'admin',
                'is_active' => true,
                'is_approved' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('deped321'),
            ]
        );
    }
}
