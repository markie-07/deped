<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LeaveRecord;

$records = LeaveRecord::take(5)->get();
foreach ($records as $r) {
    echo "ID: {$r->id}, Name: '{$r->name}', UserID: {$r->user_id}\n";
}
