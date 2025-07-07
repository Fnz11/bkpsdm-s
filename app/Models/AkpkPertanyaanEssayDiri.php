<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkPertanyaanEssayDiri extends Model
{
    protected $table = 'akpk_pertanyaan_essay_diri';
    protected $fillable = ['pertanyaan', 'status'];

    public function evaluasiEssayDiri()
    {
        return $this->hasMany(AkpkEvaluasiEssayDiri::class, 'id_pertanyaan_essay_diri');
    }
}
