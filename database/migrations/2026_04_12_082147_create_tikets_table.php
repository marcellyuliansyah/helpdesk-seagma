<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelanggan_id')->constrained('users')->onDelete('cascade');
        $table->string('judul');
        $table->text('deskripsi');
        $table->string('status')->default('menunggu verifikasi');
        
        // Tambahkan dua baris ini:
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};