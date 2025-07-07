<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkJawaban extends Model
{
    protected $table = 'akpk_jawaban';
    protected $fillable = ['skor', 'keterangan'];

    public function evaluasiDiri()
    {
        return $this->hasMany(AkpkEvaluasiDiri::class, 'id_jawaban');
    }

    public function evaluasiAtasan()
    {
        return $this->hasMany(AkpkEvaluasiAtasan::class, 'id_jawaban');
    }
}
