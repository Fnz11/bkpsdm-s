<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanList extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_lists';

    protected $fillable = [
        'nip',
        'nama_pelatihan',
        'tempat_pelatihan',
        'tanggal_pelaksanaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'penyelenggara',
        'deskripsi',
        'pelaksanaan_pelatihan_id',
        'metode_pelatihan_id',
        'jenis_pelatihan_id',
        'gambar',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    // Relasi ke pelaksanaan pelatihan
    public function pelaksanaanPelatihan()
    {
        return $this->belongsTo(ref_pelaksanaanpelatihans::class);
    }

    // Relasi ke metode pelatihan
    public function metodePelatihan()
    {
        return $this->belongsTo(ref_metodepelatihans::class);
    }

    // Relasi ke jenis pelatihan
    public function jenisPelatihan()
    {
        return $this->belongsTo(ref_jenispelatihans::class);
    }
}
