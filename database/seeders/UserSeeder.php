<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@stockify.test'],
            [
                'name' => 'Admin Stockify',
                'password' => Hash::make('AdminStockify123!'),
                'role' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'staff@stockify.test'],
            [
                'name' => 'Staff Stockify',
                'password' => Hash::make('StaffStockify123!'),
                'role' => 'staff',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}