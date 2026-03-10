<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'markjamesp11770@gmail.com'],
            [
                'name' => 'Mark James Gabriel Pisngot',
                'username' => 'Mark',
                'first_name' => 'Mark James',
                'last_name' => 'Pisngot',
                'middle_name' => 'Gabriel',
                'position' => 'ADMIN',
                'role' => 'admin',
                'is_active' => true,
                'password' => Hash::make('deped123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'markpisngot47@gmail.com'],
            [
                'name' => 'Mark Pisngot',
                'username' => 'MarkUser',
                'first_name' => 'Mark',
                'last_name' => 'Pisngot',
                'position' => 'User',
                'role' => 'user',
                'is_active' => true,
                'password' => Hash::make('deped123'),
            ]
        );
    }
}
