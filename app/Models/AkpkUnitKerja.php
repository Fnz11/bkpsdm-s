<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkpkUnitKerja extends Model
{
    protected $table = 'ref_unit_kerja';

    protected $fillable = [
        'unit_kerja',
        'kode_unit_kerja',
        'sub_unit_kerja',
        'singkatan',
    ];
}
