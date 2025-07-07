<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanLaporan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_laporans';

    protected $fillable = [
        'id_registrasi',
        'judul_laporan',
        'latar_belakang',
        'laporan_pelatihan',
        'sertifikat',
        'total_biaya',
        'status',
    ];

    // Relasi ke tabel pelatihan_2_registers
    public function registrasi()
    {
        return $this->belongsTo(PelatihanRegistrasi::class, 'id_registrasi');
    }
}
