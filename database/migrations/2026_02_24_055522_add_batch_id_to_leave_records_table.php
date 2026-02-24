<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_records', function (Blueprint $table) {
            $table->unsignedInteger('batch_id')->default(1)->after('is_processed');
        });
    }

    public function down(): void
    {
        Schema::table('leave_records', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
