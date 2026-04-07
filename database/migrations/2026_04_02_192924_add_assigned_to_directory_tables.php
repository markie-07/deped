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
        $tables = ['leave_records', 'employees', 'schools', 'positions', 'leave_types', 'remarks'];
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'assigned')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('assigned')->nullable()->default('national');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['leave_records', 'employees', 'schools', 'positions', 'leave_types', 'remarks'];
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'assigned')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('assigned');
                });
            }
        }
    }
};
