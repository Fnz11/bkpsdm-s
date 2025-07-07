<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkPertanyaanEssayAtasan extends Model
{
    protected $table = 'akpk_pertanyaan_essay_atasan';
    protected $fillable = ['pertanyaan', 'status'];

    public function evaluasiEssayAtasan()
    {
        return $this->hasMany(AkpkEvaluasiEssayAtasan::class, 'id_pertanyaan_essay_atasan');
    }
}
