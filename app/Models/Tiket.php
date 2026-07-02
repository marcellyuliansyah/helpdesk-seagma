<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'teknisi_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'status',
        'latitude',
        'longitude',
        'foto_bukti',
    ];

    // INI YANG HARUS DITAMBAHKAN: Relasi ke tabel users
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    // Relasi ke Teknisi
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
