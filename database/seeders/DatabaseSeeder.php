<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@finance.com',
            'role' => 'admin', // Role Admin
            'password' => Hash::make('password'), // Password default: password
        ]);

        // 2. Buat Akun MANAGER
        User::create([
            'name' => 'Bapak Manajer',
            'email' => 'manager@finance.com',
            'role' => 'manager', // Role Manager
            'password' => Hash::make('password'),
        ]);

        // Opsional: Buat user biasa jika perlu
    }
}
