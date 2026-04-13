<?php

use App\Models\User;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = User::all(['id', 'first_name', 'last_name', 'email', 'email_hash']);

echo "Users in DEPED:\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->first_name} {$user->last_name} | Email: {$user->email} | Hash: {$user->email_hash}\n";
}
