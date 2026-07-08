<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom kecamatan dan kecamatan_tugas
            $table->string('kecamatan')->nullable()->after('alamat_lengkap');
            $table->string('kecamatan_tugas')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kecamatan_tugas']);
        });
    }
};