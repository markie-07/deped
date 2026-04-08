<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Data Migration: Ensure first_name and last_name are populated from name if empty
        $users = DB::table('users')->where(function($query) {
            $query->whereNull('first_name')->orWhere('first_name', '');
        })->get();

        foreach ($users as $user) {
            if ($user->name) {
                $parts = explode(' ', $user->name);
                $firstName = $parts[0] ?? '';
                $lastName = $parts[count($parts) - 1] ?? '';
                
                DB::table('users')->where('id', $user->id)->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);
            }
        }

        // 2. Drop the column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });
    }
};
