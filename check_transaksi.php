<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Transaksi Table Columns ===\n";
$columns = Schema::getColumnListing('transaksi');
print_r($columns);

echo "\n=== Transaksi Table Data ===\n";
$transaksis = DB::table('transaksi')->limit(5)->get();
foreach ($transaksis as $t) {
    echo json_encode($t, JSON_PRETTY_PRINT) . "\n";
}
