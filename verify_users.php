<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Admin;

echo "=== Admin Records ===\n";
Admin::all(['ID_ADMIN', 'USERNAME', 'NAMA_ADMIN'])->each(function($admin) {
    echo $admin->ID_ADMIN . ": " . $admin->USERNAME . " (" . $admin->NAMA_ADMIN . ")\n";
});

echo "\n=== User Records ===\n";
User::all(['id', 'name', 'email'])->each(function($user) {
    echo $user->id . ": " . $user->name . " (" . $user->email . ")\n";
});
