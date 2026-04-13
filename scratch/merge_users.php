<?php

use App\Models\User;
use App\Models\LeaveRecord;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$oldId = 11;
$newId = 13;

echo "Merging User $oldId into $newId...\n";

$oldUser = User::find($oldId);
$newUser = User::find($newId);

if (!$oldUser) {
    echo "Old user $oldId not found. Skipping.\n";
    exit;
}

if (!$newUser) {
    echo "New user $newId not found. Creating link...\n";
    // If 13 doesn't exist, we might just want to keep 11. But in our case 13 exists.
    exit;
}

// Re-assign leave records
$affected = LeaveRecord::where('user_id', $oldId)->update(['user_id' => $newId]);
echo "Updated $affected leave records from ID $oldId to $newId.\n";

// Delete the duplicate user
$oldUser->delete();
echo "Deleted duplicate user ID $oldId.\n";

echo "Done.\n";
