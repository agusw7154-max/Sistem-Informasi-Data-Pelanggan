<?php
// Simple script to bootstrap Laravel app and check for required tables
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap the application kernel so facades and database are usable
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = ['pelanggan','produk','transaksi','pembayaran'];
$result = [];
foreach ($tables as $t) {
    try {
        $result[$t] = Schema::hasTable($t) ? true : false;
    } catch (Exception $e) {
        $result['error'] = $e->getMessage();
        break;
    }
}

echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;