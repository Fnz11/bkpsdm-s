<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkPertanyaanAtasan extends Model
{
    protected $table = 'akpk_pertanyaan_atasan';
    protected $fillable = ['pertanyaan', 'deskripsi', 'id_kategori', 'standar_min', 'id_jabatan', 'status','tanggal_pengisian'];

    public function kategori()
    {
        return $this->belongsTo(AkpkKategori::class, 'id_kategori');
    }

    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'id_jabatan');
    }

    public function evaluasiAtasan()
    {
        return $this->hasMany(AkpkEvaluasiAtasan::class, 'id_pertanyaan');
    }
}
