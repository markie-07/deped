<?php

use App\Models\LeaveRecord;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$record = LeaveRecord::latest()->first();

if ($record) {
    echo "Latest Leave Record in DEPED:\n";
    echo "ID: {$record->id}\n";
    echo "Name: {$record->name}\n";
    echo "User ID: {$record->user_id}\n";
    echo "Incharge: {$record->incharge}\n";
    echo "Assigned: {$record->assigned}\n";
    echo "Created At: {$record->created_at}\n";
    
    if ($record->user_id) {
        $user = \App\Models\User::find($record->user_id);
        if ($user) {
            echo "Assigned to User: {$user->first_name} {$user->last_name} (ID: {$user->id})\n";
        }
    }
} else {
    echo "No records found.\n";
}
