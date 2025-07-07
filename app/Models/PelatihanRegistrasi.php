<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanRegistrasi extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_registrasis';
    protected $fillable = [
        'nip',
        'id_pelatihan',
        'tanggal_daftar',
        'biaya_akomodasi',
        'biaya_hotel',
        'biaya_pelatihan',
        'uang_harian',
        'file_usulan',
        'file_penawaran',
        'status',
    ];

    // Relasi ke pelatihan_1_lists
    public function pelatihan()
    {
        return $this->belongsTo(PelatihanList::class, 'id_pelatihan');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    //Relasi ke laporan pelatihan (lap_pelat_simelati)
    public function laporan()
    {
        return $this->hasOne(PelatihanLaporan::class, 'id_registrasi');
    }
}
