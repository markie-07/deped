<?php

use App\Models\User;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = User::all(['id', 'first_name', 'last_name', 'role']);

echo "User Roles in DEPED:\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->first_name} {$user->last_name} | Role: {$user->role}\n";
}
