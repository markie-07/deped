<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'markjamesp11770@gmail.com'],
            [
                'name' => 'Mark James',
                'email' => 'markjamesp11770@gmail.com',
                'password' => Hash::make('deped123'),
                'email_verified_at' => now(),
            ]
        );

        // Test Account
        User::updateOrCreate(
            ['email' => 'admin@deped.gov.ph'],
            [
                'name' => 'DepEd Admin',
                'email' => 'admin@deped.gov.ph',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Second Account
        User::updateOrCreate(
            ['email' => 'markpisngot47@gmail.com'],
            [
                'name' => 'Mark Pisngot',
                'email' => 'markpisngot47@gmail.com',
                'password' => Hash::make('deped123'),
                'email_verified_at' => now(),
            ]
        );

        // Populate directory tables from existing leave records
        $this->call(DirectorySeeder::class);
    }
}
