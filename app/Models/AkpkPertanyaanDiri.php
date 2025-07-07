<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkPertanyaanDiri extends Model
{
    protected $table = 'akpk_pertanyaan_diri';
    protected $fillable = ['pertanyaan', 'deskripsi', 'id_kategori', 'standar_min', 'id_jabatan', 'status','tanggal_pengisian'];

    public function kategori()
    {
        return $this->belongsTo(AkpkKategori::class, 'id_kategori');
    }

    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'id_jabatan');
    }

    public function evaluasiDiri()
    {
        return $this->hasMany(AkpkEvaluasiDiri::class, 'id_pertanyaan');
    }
}
