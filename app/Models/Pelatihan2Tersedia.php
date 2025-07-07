<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan2Tersedia extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_2_tersedias';
    protected $fillable = [
        'nama_pelatihan',
        'jenispelatihan_id',
        'metodepelatihan_id',
        'pelaksanaanpelatihan_id',
        'penyelenggara_pelatihan',
        'tempat_pelatihan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tutup_pendaftaran',
        'kuota',
        'biaya',
        'deskripsi',
        'gambar',
        'status_pelatihan',
    ];

    protected $with = [
        'jenispelatihan',
        'metodepelatihan',
        'pelaksanaanpelatihan',
    ];

    // Relasi ke Jenis Pelatihan
    public function jenispelatihan()
    {
        return $this->belongsTo(ref_jenispelatihans::class, 'jenispelatihan_id', 'id');
    }

    // Relasi ke Metode Pelatihan
    public function metodepelatihan()
    {
        return $this->belongsTo(ref_metodepelatihans::class, 'metodepelatihan_id', 'id');
    }

    // Relasi ke Pelaksanaan Pelatihan
    public function pelaksanaanpelatihan()
    {
        return $this->belongsTo(ref_pelaksanaanpelatihans::class, 'pelaksanaanpelatihan_id', 'id');
    }

    // Relasi ke Pendaftaran Pelatihan
    public function pendaftaran()
    {
        return $this->hasMany(Pelatihan3Pendaftaran::class, 'tersedia_id', 'id');
    }
}
