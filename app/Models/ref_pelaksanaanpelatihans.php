<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_pelaksanaanpelatihans extends Model
{
    use HasFactory;

    protected $table = 'ref_pelaksanaanpelatihans';
    protected $fillable = [
        'kode_pelaksanaanpelatihan',
        'pelaksanaan_pelatihan',
    ];
}
