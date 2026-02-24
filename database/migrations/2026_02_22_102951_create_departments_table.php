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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('employee_name')->nullable();
            $table->string('position')->nullable();
            $table->string('school')->nullable();
            $table->string('type_of_leave')->nullable();
            $table->string('inclusive_dates')->nullable();
            $table->date('date_of_action')->nullable();
            $table->string('deduction_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
