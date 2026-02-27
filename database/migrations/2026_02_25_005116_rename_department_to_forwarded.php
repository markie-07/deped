<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leave_records', function (Blueprint $table) {
            $table->renameColumn('department', 'forwarded');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('department', 'forwarded');
        });

        Schema::rename('departments', 'forwardeds');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('forwardeds', 'departments');

        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('forwarded', 'department');
        });

        Schema::table('leave_records', function (Blueprint $table) {
            $table->renameColumn('forwarded', 'department');
        });
    }
};
