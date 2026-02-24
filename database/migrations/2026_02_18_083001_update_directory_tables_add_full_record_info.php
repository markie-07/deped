<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Schools Table ──
        Schema::table('schools', function (Blueprint $table) {
            // Drop old latest_ columns
            $table->dropColumn(['latest_employee', 'latest_inclusive_dates', 'latest_date_of_action', 'latest_remarks']);
            // Add full leave record columns
            $table->string('employee_name')->nullable()->after('type');
            $table->string('position')->nullable()->after('employee_name');
            $table->string('type_of_leave')->nullable()->after('position');
            $table->string('inclusive_dates')->nullable()->after('type_of_leave');
            $table->string('remarks')->nullable()->after('inclusive_dates');
            $table->date('date_of_action')->nullable()->after('remarks');
            $table->string('deduction_remarks')->nullable()->after('date_of_action');
        });

        // ── Positions Table ──
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn(['latest_employee', 'latest_inclusive_dates', 'latest_date_of_action']);
            $table->string('employee_name')->nullable()->after('name');
            $table->string('school')->nullable()->after('employee_name');
            $table->string('type_of_leave')->nullable()->after('school');
            $table->string('inclusive_dates')->nullable()->after('type_of_leave');
            $table->string('remarks')->nullable()->after('inclusive_dates');
            $table->date('date_of_action')->nullable()->after('remarks');
            $table->string('deduction_remarks')->nullable()->after('date_of_action');
        });

        // ── Leave Types Table ──
        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn(['latest_employee', 'latest_inclusive_dates', 'latest_date_of_action']);
            $table->string('employee_name')->nullable()->after('name');
            $table->string('position')->nullable()->after('employee_name');
            $table->string('school')->nullable()->after('position');
            $table->string('inclusive_dates')->nullable()->after('school');
            $table->string('remarks')->nullable()->after('inclusive_dates');
            $table->date('date_of_action')->nullable()->after('remarks');
            $table->string('deduction_remarks')->nullable()->after('date_of_action');
        });

        // ── Remarks Table ──
        Schema::table('remarks', function (Blueprint $table) {
            $table->dropColumn(['latest_employee', 'latest_inclusive_dates', 'latest_date_of_action']);
            $table->string('employee_name')->nullable()->after('name');
            $table->string('position')->nullable()->after('employee_name');
            $table->string('school')->nullable()->after('position');
            $table->string('type_of_leave')->nullable()->after('school');
            $table->string('inclusive_dates')->nullable()->after('type_of_leave');
            $table->date('date_of_action')->nullable()->after('inclusive_dates');
            $table->string('deduction_remarks')->nullable()->after('date_of_action');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['employee_name', 'position', 'type_of_leave', 'inclusive_dates', 'remarks', 'date_of_action', 'deduction_remarks']);
            $table->string('latest_employee')->nullable();
            $table->string('latest_inclusive_dates')->nullable();
            $table->date('latest_date_of_action')->nullable();
            $table->string('latest_remarks')->nullable();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn(['employee_name', 'school', 'type_of_leave', 'inclusive_dates', 'remarks', 'date_of_action', 'deduction_remarks']);
            $table->string('latest_employee')->nullable();
            $table->string('latest_inclusive_dates')->nullable();
            $table->date('latest_date_of_action')->nullable();
        });

        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn(['employee_name', 'position', 'school', 'inclusive_dates', 'remarks', 'date_of_action', 'deduction_remarks']);
            $table->string('latest_employee')->nullable();
            $table->string('latest_inclusive_dates')->nullable();
            $table->date('latest_date_of_action')->nullable();
        });

        Schema::table('remarks', function (Blueprint $table) {
            $table->dropColumn(['employee_name', 'position', 'school', 'type_of_leave', 'inclusive_dates', 'date_of_action', 'deduction_remarks']);
            $table->string('latest_employee')->nullable();
            $table->string('latest_inclusive_dates')->nullable();
            $table->date('latest_date_of_action')->nullable();
        });
    }
};
