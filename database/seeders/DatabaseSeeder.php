<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Default Admin
        User::updateOrCreate(
            ['email' => 'budi@gmail.com'], // Kunci pencarian (Cek apakah email ini ada)
            [
                'name' => 'Budi',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => 'aktif',
                'no_telepon' => '081234567890',
            ]
        );

        // 2. Akun Default Pimpinan
        User::updateOrCreate(
            ['email' => 'pimpinan@gmail.com'],
            [
                'name' => 'Bapak Pimpinan',
                'password' => Hash::make('12345678'),
                'role' => 'pimpinan',
                'status' => 'aktif',
                'no_telepon' => '081211223344',
            ]
        );
    }
}