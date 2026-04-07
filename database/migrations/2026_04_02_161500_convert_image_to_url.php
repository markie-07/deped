<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change attempt_image to TEXT to store the clickable URL of the person's face
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE face_recognition_logs MODIFY COLUMN attempt_image TEXT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE face_recognition_logs MODIFY COLUMN attempt_image LONGBLOB NULL");
    }
};
