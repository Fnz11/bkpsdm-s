<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class eva_2_atasan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_5_pascadiklat_atasan';

    protected $fillable = [
        'nip',
        'nama',
        'pangkat_golongan',
        'jabatan',
        'unit_kerja',
        'no_hp',
    ];
}
