<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting high-security data fortification (v4)...\n";

// 1. Ensure email_hash column exists
if (!Schema::hasColumn('users', 'email_hash')) {
    echo "Adding email_hash column to users table...\n";
    Schema::table('users', function ($table) {
        $table->string('email_hash')->nullable()->index()->after('email');
    });
}

// 2. Fortify Users
$users = DB::table('users')->get();
foreach ($users as $user) {
    $updates = [];
    
    // Email & Hash
    $email = $user->email;
    $isEncrypted = false;
    try {
        Crypt::decryptString($email);
        $isEncrypted = true;
    } catch (\Exception $e) {}

    if (!$isEncrypted && !empty($email)) {
        echo "Encrypting email for user ID {$user->id}...\n";
        $updates['email'] = Crypt::encryptString($email);
        $updates['email_hash'] = hash('sha256', strtolower($email));
    } elseif ($isEncrypted && empty($user->email_hash)) {
        $decryptedEmail = Crypt::decryptString($email);
        $updates['email_hash'] = hash('sha256', strtolower($decryptedEmail));
    }

    // Other sensitive fields
    $fields = ['profile_image', 'cover_image', 'face_descriptor'];
    foreach ($fields as $field) {
        $val = $user->$field;
        if (empty($val)) continue;

        $alreadyEncrypted = false;
        try {
            Crypt::decryptString($val);
            $alreadyEncrypted = true;
        } catch (\Exception $e) {}

        if (!$alreadyEncrypted) {
            echo "Encrypting {$field} for user ID {$user->id}...\n";
            $updates[$field] = Crypt::encryptString($val);
        }
    }

    if (!empty($updates)) {
        DB::table('users')->where('id', $user->id)->update($updates);
    }
}

// 3. Fortify Face Recognition Logs
if (Schema::hasTable('face_recognition_logs')) {
    // Ensure columns are TEXT to support encryption lengths
    echo "Ensuring face_recognition_logs columns are TEXT...\n";
    try {
        DB::statement('ALTER TABLE face_recognition_logs MODIFY COLUMN distance TEXT');
        DB::statement('ALTER TABLE face_recognition_logs MODIFY COLUMN confidence TEXT');
    } catch (\Exception $e) {
        echo "Warning: Could not alter columns (might be already TEXT): " . $e->getMessage() . "\n";
    }

    $logs = DB::table('face_recognition_logs')->get();
    foreach ($logs as $log) {
        $updates = [];
        foreach (['distance', 'confidence'] as $field) {
            $val = $log->$field;
            if (empty($val)) continue;

            $alreadyEncrypted = false;
            try {
                Crypt::decryptString($val);
                $alreadyEncrypted = true;
            } catch (\Exception $e) {}

            if (!$alreadyEncrypted) {
                echo "Encrypting {$field} for log ID {$log->id}...\n";
                $updates[$field] = Crypt::encryptString($val);
            }
        }

        if (!empty($updates)) {
            DB::table('face_recognition_logs')->where('id', $log->id)->update($updates);
        }
    }
}

echo "Security fortification complete. You can now restore the model casts.\n";
