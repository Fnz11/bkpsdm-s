<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jenispelatihans extends Model
{
    use HasFactory;

    protected $table = 'ref_jenispelatihans';

    protected $fillable = [
        'kode_jenispelatihan',
        'jenis_pelatihan',
    ];

    // Relasi ke Pelatihan2Tersedia
    public function tersedia()
    {
        return $this->hasMany(Pelatihan2Tersedia::class, 'jenispelatihan_id');
    }
}
