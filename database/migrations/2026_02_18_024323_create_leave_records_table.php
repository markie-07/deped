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
        Schema::create('leave_records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('school');
            $table->string('type_of_leave');
            $table->string('inclusive_dates');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('leave_records');
    }
};
