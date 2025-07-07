<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ref_namapelatihans extends Model
{
    protected $table = 'ref_namapelatihans';
    protected $fillable = [
        'nip',
        'kode_namapelatihan',
        'nama_pelatihan',
        'jenispelatihan_id',
        'keterangan',
        'status',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    // Relasi ke Jenis Pelatihan
    public function jenispelatihan()
    {
        return $this->belongsTo(ref_jenispelatihans::class, 'jenispelatihan_id', 'id');
    }
}
