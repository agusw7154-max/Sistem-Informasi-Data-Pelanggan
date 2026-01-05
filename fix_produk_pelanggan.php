<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

$config = require __DIR__ . '/config/database.php';

$db = new DB();
$db->addConnection($config['connections']['mysql']);
$db->setAsGlobal();

try {
    DB::statement('ALTER TABLE produk MODIFY ID_PELANGGAN char(5) DEFAULT NULL');
    echo "✓ Berhasil! Kolom ID_PELANGGAN sekarang nullable.\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
