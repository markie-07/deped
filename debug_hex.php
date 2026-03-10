<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LeaveRecord;

$rems = LeaveRecord::distinct()->pluck('remarks')->toArray();
foreach($rems as $rem) {
    if ($rem === null) { echo "NULL\n"; continue; }
    echo bin2hex($rem) . ": [" . $rem . "]\n";
}
