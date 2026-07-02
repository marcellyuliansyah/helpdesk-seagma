<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Menambahkan kolom foto_bukti (tipe string, boleh kosong untuk data lama)
            $table->string('foto_bukti')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('foto_bukti');
        });
    }
};