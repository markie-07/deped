<?php

use App\Models\User;
use App\Models\LeaveRecord;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Finding James Pisngot in deped database...\n";

$users = User::all();
foreach ($users as $u) {
    if (str_contains(strtolower($u->first_name . ' ' . $u->last_name), 'james')) {
        echo "ID: {$u->id}, Name: {$u->first_name} {$u->last_name}, Assigned: {$u->assigned}\n";
    }
}
