<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_kategorijabatans extends Model
{
    use HasFactory;
    protected $table = 'ref_kategorijabatans'; // Pastikan tabel sesuai dengan database
    protected $fillable = [
        'kode_kategorijabatan',
        'kategori_jabatan',
    ];

    public function jabatan()
    {
        return $this->hasMany(ref_jabatans::class, 'kategorijabatan_id', 'id');
    }
}
