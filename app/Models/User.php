<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Tiket;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'status',
        'is_approved',
        'hari_libur',
        'kecamatan',
        'kecamatan_tugas',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu (Casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean', // 👈 TAMBAHKAN INI: Mengubah nilai 1/0 di database menjadi true/false biner di Laravel
    ];

    /**
     * Relasi: Satu User (Pelanggan) memiliki banyak Tiket Pengaduan
     */
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'pelanggan_id');
    }

    /**
     * Relasi: Satu User (Teknisi) memiliki banyak Tugas Penanganan Tiket
     * Relasi ini digunakan oleh AdminController untuk menghitung beban kerja via withCount('tugasTeknisi')
     */
    public function tugasTeknisi()
    {
        return $this->hasMany(Tiket::class, 'teknisi_id');
    }
}