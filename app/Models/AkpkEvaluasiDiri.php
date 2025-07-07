<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpkEvaluasiDiri extends Model
{
    use HasFactory;

    protected $table = 'akpk_evaluasi_diri';

    protected $fillable = [
        'nip',
        'id_jawaban',
        'id_pertanyaan',
        'id_tahun_evaluasi',
        'tanggal_pengisian',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function jawaban() {
        return $this->belongsTo(AkpkJawaban::class, 'id_jawaban');
    }

    public function pertanyaan() {
        return $this->belongsTo(AkpkPertanyaanDiri::class, 'id_pertanyaan');
    }

    public function tahunEvaluasi() {
        return $this->belongsTo(AkpkTahunEvaluasi::class, 'id_tahun_evaluasi');
    }
}

