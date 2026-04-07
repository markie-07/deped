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
        // Revert LONGBLOB back to a text/string column to store the accessible URL of the audit image.
        // This makes it easy for administrators to click and view the person's face directly from the database.
        DB::statement('ALTER TABLE face_recognition_logs MODIFY COLUMN attempt_image TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE face_recognition_logs MODIFY COLUMN attempt_image LONGBLOB');
    }
};
