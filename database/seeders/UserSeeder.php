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
                'name' => 'Mark James',
                'password' => Hash::make('deped123'),
            ]
        );
    }
}
