<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::first();
echo "Profile Image Path: " . $user->profile_image . "\n";
$fullPath = storage_path('app/public/' . $user->profile_image);
echo "Full Path: " . $fullPath . "\n";
echo "Exists: " . (file_exists($fullPath) ? 'Yes' : 'No') . "\n";
if (file_exists($fullPath)) {
    echo "Size: " . filesize($fullPath) . " bytes\n";
}
