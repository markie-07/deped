<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
foreach($tables as $table) {
    $table_array = get_object_vars($table);
    $table_name = reset($table_array);
    echo $table_name . ': ' . DB::table($table_name)->count() . PHP_EOL;
}
