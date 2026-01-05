<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;

echo "=== Admin Credentials for Login ===\n\n";
Admin::all(['ID_ADMIN', 'USERNAME', 'PASSWORD', 'NAMA_ADMIN'])->each(function($admin) {
    echo "ID: " . $admin->ID_ADMIN . "\n";
    echo "Email: " . strtolower($admin->USERNAME) . "@admin.local\n";
    echo "Password: " . $admin->PASSWORD . "\n";
    echo "Name: " . $admin->NAMA_ADMIN . "\n";
    echo "---\n";
});

echo "\nDemo Account:\n";
echo "Email: demo@example.com\n";
echo "Password: password\n";
