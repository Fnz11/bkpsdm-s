<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpkEvaluasiEssayDiri extends Model
{
    use HasFactory;

    protected $table = 'akpk_evaluasi_essay_diri';

    protected $fillable = [
        'nip',
        'jawaban',
        'id_tahun_evaluasi',
        'id_pertanyaan_essay_diri'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function pertanyaanEssay() {
        return $this->belongsTo(AkpkPertanyaanEssayDiri::class, 'id_pertanyaan_essay_diri');
    }

    public function tahunEvaluasi() {
        return $this->belongsTo(AkpkTahunEvaluasi::class, 'id_tahun_evaluasi');
    }
}
