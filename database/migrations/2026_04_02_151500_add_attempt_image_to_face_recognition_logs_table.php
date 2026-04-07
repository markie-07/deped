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
        // Try to add the column, or modify it if it already exists from a previous partial run
        try {
            DB::statement('ALTER TABLE face_recognition_logs ADD attempt_image LONGBLOB AFTER status');
        } catch (\Exception $e) {
            DB::statement('ALTER TABLE face_recognition_logs MODIFY COLUMN attempt_image LONGBLOB');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('face_recognition_logs', function (Blueprint $table) {
            $table->dropColumn('attempt_image');
        });
    }
};
