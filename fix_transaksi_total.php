<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Calculating total_bayar from detail_transaksi and produk ===\n";

// Get all transaksi
$transaksis = DB::table('transaksi')->get();

foreach ($transaksis as $t) {
    // Calculate total: JOIN detail_transaksi with produk, sum(quantity * price)
    $total = DB::table('detail_transaksi')
        ->leftJoin('produk', 'detail_transaksi.ID_PRODUK', '=', 'produk.ID_PRODUK')
        ->where('detail_transaksi.ID_TRANSAKSI', $t->ID_TRANSAKSI)
        ->selectRaw('SUM(JUMLAH * COALESCE(produk.HARGA, 0)) as total')
        ->first()
        ->total ?? 0;
    
    // Update transaksi
    DB::table('transaksi')
        ->where('ID_TRANSAKSI', $t->ID_TRANSAKSI)
        ->update(['total_bayar' => $total]);
    
    echo "Updated " . $t->ID_TRANSAKSI . ": Rp " . number_format($total, 0, ',', '.') . "\n";
}

echo "\n=== Final Data ===\n";
$final = DB::table('transaksi')->get();
foreach ($final as $t) {
    echo $t->ID_TRANSAKSI . ": Rp " . number_format($t->total_bayar ?? 0, 0, ',', '.') . "\n";
}
