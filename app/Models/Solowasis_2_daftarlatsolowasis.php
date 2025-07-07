<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solowasis_2_daftarlatsolowasis extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun',
        'nama_pelatihan',
        'jumlah_jp',
        'jumlah_peserta',
        'keterangan',
    ];
}

