<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJabatan extends Model
{
    protected $table = 'ref_jabatan';
    protected $fillable = ['jabatan', 'jenis_jabatan'];

    public function pertanyaanAtasan()
    {
        return $this->hasMany(AkpkPertanyaanAtasan::class, 'id_jabatan');
    }

    public function pertanyaanDiri()
    {
        return $this->hasMany(AkpkPertanyaanDiri::class, 'id_jabatan');
    }
}
