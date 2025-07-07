<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkKategori extends Model
{
    protected $table = 'akpk_kategori';
    protected $fillable = ['kategori'];

    public function pertanyaanAtasan()
    {
        return $this->hasMany(AkpkPertanyaanAtasan::class, 'id_kategori');
    }

    public function pertanyaanDiri()
    {
        return $this->hasMany(AkpkPertanyaanDiri::class, 'id_kategori');
    }
}
