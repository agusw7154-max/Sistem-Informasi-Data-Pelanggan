<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admins from admin table
        $admins = Admin::all();

        foreach ($admins as $admin) {
            // Create user from admin data
            User::firstOrCreate(
                ['email' => strtolower($admin->USERNAME) . '@admin.local'],
                [
                    'name' => $admin->NAMA_ADMIN ?? $admin->USERNAME,
                    'email' => strtolower($admin->USERNAME) . '@admin.local',
                    'password' => Hash::make($admin->PASSWORD ?? 'password123'),
                ]
            );
        }

        // Optionally add a default demo user
        User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
