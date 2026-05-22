<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini ada

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom role menjadi teks biasa (VARCHAR) dengan panjang maksimal 50 karakter
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'pelanggan'");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM jika di-rollback (sesuaikan isinya dengan ENUM awal Anda)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('pelanggan', 'admin', 'teknisi') DEFAULT 'pelanggan'");
    }
};