<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Pembayaran Table Columns ===\n";
$columns = Schema::getColumnListing('pembayaran');
print_r($columns);

echo "\n=== Pembayaran Table Data ===\n";
$data = DB::table('pembayaran')->limit(5)->get();
foreach ($data as $p) {
    echo json_encode($p, JSON_PRETTY_PRINT) . "\n";
}
