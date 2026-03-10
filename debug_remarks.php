<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LeaveRecord;
use Illuminate\Support\Facades\DB;

$results = LeaveRecord::whereNotNull('remarks')
    ->where('remarks', '!=', '')
    ->select('remarks', DB::raw('count(*) as count'))
    ->groupBy('remarks')
    ->get();

foreach($results as $r) {
    echo $r->remarks . ': ' . $r->count . PHP_EOL;
}
