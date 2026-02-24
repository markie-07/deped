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
            $table->string('department')->nullable()->after('name');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('department')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_records', function (Blueprint $table) {
            $table->dropColumn('department');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }
};
