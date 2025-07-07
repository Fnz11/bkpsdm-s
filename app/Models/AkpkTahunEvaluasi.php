<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkTahunEvaluasi extends Model
{
    protected $table = 'akpk_tahun_evaluasi';
    protected $fillable = ['tanggal_buka', 'tanggal_tutup', 'tahun'];

    public function evaluasiDiri()
    {
        return $this->hasMany(AkpkEvaluasiDiri::class, 'id_tahun_evaluasi');
    }

    public function evaluasiAtasan()
    {
        return $this->hasMany(AkpkEvaluasiAtasan::class, 'id_tahun_evaluasi');
    }

    public function evaluasiEssayAtasan()
    {
        return $this->hasMany(AkpkEvaluasiEssayAtasan::class, 'id_tahun_evaluasi');
    }

    public function evaluasiEssayDiri()
    {
        return $this->hasMany(AkpkEvaluasiEssayDiri::class, 'id_tahun_evaluasi');
    }
}
