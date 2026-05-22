<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;
    
    // Tambahkan baris ini agar semua kolom bisa diisi otomatis
    protected $guarded = [];
}