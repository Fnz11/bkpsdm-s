<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan4Laporan extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_4_laporans';
    protected $fillable = [
        'pendaftaran_id',
        'judul_laporan',
        'latar_belakang',
        'sertifikat',
        'total_biaya',
        'laporan',
        'hasil_pelatihan',
    ];

    // protected $with = [
    //     'pendaftaran',
    // ];

    // Relasi ke pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pelatihan3Pendaftaran::class, 'pendaftaran_id', 'id');
    }
}

