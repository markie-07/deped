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
        Schema::table('users', function (Blueprint $table) {
            $table->float('profile_offset_x')->default(0)->after('profile_image');
            $table->float('profile_offset_y')->default(0)->after('profile_offset_x');
            $table->float('profile_zoom')->default(1.0)->after('profile_offset_y');
            $table->float('cover_offset_x')->default(50)->after('cover_image');
            $table->float('cover_offset_y')->default(50)->after('cover_offset_x');
            $table->float('cover_zoom')->default(1.0)->after('cover_offset_y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_offset_x', 'profile_offset_y', 'profile_zoom', 'cover_offset_x', 'cover_offset_y', 'cover_zoom']);
        });
    }
};
