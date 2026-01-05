<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Produk Table Columns ===\n";
$columns = Schema::getColumnListing('produk');
print_r($columns);

echo "\n=== Sample Produk Data ===\n";
$data = DB::table('produk')->limit(3)->get();
foreach ($data as $p) {
    echo json_encode($p, JSON_PRETTY_PRINT) . "\n";
}
