<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkGolongan extends Model
{
    protected $table = 'ref_golongans';

    protected $fillable = [
        'kode_golongan',
        'jenis_asn',
        'golongan',
        'pangkat',
        'pangkat_golongan',
    ];
}
