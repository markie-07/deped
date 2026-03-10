<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LeaveRecord;
use Illuminate\Support\Facades\Auth;

// Mock login as the first user if any
$user = \App\Models\User::first();
if ($user) Auth::login($user);

$employees = LeaveRecord::select('name')
    ->selectRaw('MAX(position) as position')
    ->selectRaw('MAX(school) as school')
    ->selectRaw('COUNT(*) as record_count')
    ->groupBy('name')
    ->orderBy('name')
    ->get();

header('Content-Type: application/json');
echo json_encode($employees, JSON_PRETTY_PRINT);
echo "\n";
