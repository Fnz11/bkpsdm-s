<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan2Usulan extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_2_usulans';
    protected $fillable = [
        'nip_pengusul',
        'nama_pelatihan',
        'jenispelatihan_id',
        'metodepelatihan_id',
        'pelaksanaanpelatihan_id',
        'penyelenggara_pelatihan',
        'tempat_pelatihan',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_penawaran',
        'keterangan',
        'estimasi_biaya',
        'realisasi_biaya',
    ];

    protected $with = [
        'user',
        'jenispelatihan',
        'metodepelatihan',
        'pelaksanaanpelatihan',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'nip_pengusul', 'nip');
    }

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
        return $this->hasOne(Pelatihan3Pendaftaran::class, 'usulan_id', 'id');
    }
}
