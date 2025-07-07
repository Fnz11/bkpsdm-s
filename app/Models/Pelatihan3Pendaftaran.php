<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan3Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_3_pendaftarans';
    protected $fillable = [
        'kode_pendaftaran',
        'user_nip',
        'dokumen_id',
        'tersedia_id',
        'usulan_id',
        'keterangan',
        'tanggal_pendaftaran',
        'status_verifikasi',
        'status_peserta',
    ];

    // protected $with = [
    //     'user',
    //     'tersedia',
    //     'usulan',
    //     // 'dokumens',
    // ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_nip', 'nip');
    }

    // Relasi ke Tersedia Pelatihan
    public function tersedia()
    {
        return $this->belongsTo(Pelatihan2Tersedia::class, 'tersedia_id', 'id');
    }

    // Relasi ke Usulan Pelatihan
    public function usulan()
    {
        return $this->belongsTo(Pelatihan2Usulan::class, 'usulan_id', 'id');
    }

    // Relasi ke Laporan Pelatihan
    public function laporan()
    {
        return $this->hasOne(Pelatihan4Laporan::class, 'pendaftaran_id', 'id');
    }

    // Relasi ke Dokumen Pelatihan
    public function dokumen()
    {
        return $this->belongsTo(Pelatihan3Dokumen::class, 'dokumen_id');
    }
}
