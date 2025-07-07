<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpkEvaluasiAtasan extends Model
{
    use HasFactory;

    protected $table = 'akpk_evaluasi_atasan';

    protected $fillable = [
        'nip_atasan',
        'nip_bawahan',
        'id_jawaban',
        'id_pertanyaan',
        'id_tahun_evaluasi',
        'tanggal_pengisian',
    ];

    public function atasan() {
        return $this->belongsTo(User::class, 'nip_atasan', 'nip');
    }

    public function bawahan() {
        return $this->belongsTo(User::class, 'nip_bawahan', 'nip');
    }

    public function jawaban() {
        return $this->belongsTo(AkpkJawaban::class, 'id_jawaban');
    }

    public function pertanyaan() {
        return $this->belongsTo(AkpkPertanyaanAtasan::class, 'id_pertanyaan');
    }

    public function tahunEvaluasi() {
        return $this->belongsTo(AkpkTahunEvaluasi::class, 'id_tahun_evaluasi');
    }
}
