<?php

use App\Models\User;
use App\Models\LeaveRecord;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Updating James Pisngot's records (ID 14) to match his regional assignment...\n";

$user = User::find(14); 

if (!$user) {
    echo "User 14 not found.\n";
    exit;
}

$region = $user->assigned; 
echo "User region is: $region\n";

if (!$region) {
    echo "User has no assignment. Skipping.\n";
    exit;
}

// Update by user_id
$affected1 = LeaveRecord::where('user_id', $user->id)->update(['assigned' => $region]);
// Update by name (just in case there are records with no user_id yet)
$affected2 = LeaveRecord::where('incharge', 'James Pisngot')
    ->orWhere('incharge', 'James')
    ->whereNull('user_id')
    ->update(['assigned' => $region]);

echo "Updated $affected1 records by user_id.\n";
echo "Updated $affected2 records by name.\n";

echo "Done.\n";
