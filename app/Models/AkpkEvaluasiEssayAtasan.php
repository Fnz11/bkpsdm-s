<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpkEvaluasiEssayAtasan extends Model
{
    use HasFactory;

    protected $table = 'akpk_evaluasi_essay_atasan';

    protected $fillable = [
        'nip_atasan',
        'nip_bawahan',
        'jawaban',
        'id_tahun_evaluasi',
        'id_pertanyaan_essay_atasan'
    ];

    public function atasan() {
        return $this->belongsTo(User::class, 'nip_atasan', 'nip');
    }

    public function bawahan() {
        return $this->belongsTo(User::class, 'nip_bawahan', 'nip');
    }

    public function pertanyaanEssay() {
        return $this->belongsTo(AkpkPertanyaanEssayAtasan::class, 'id_pertanyaan_essay_atasan');
    }

    public function tahunEvaluasi() {
        return $this->belongsTo(AkpkTahunEvaluasi::class, 'id_tahun_evaluasi');
    }
}
