<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ref_metodepelatihans extends Model
{
    use HasFactory;
    protected $table = 'ref_metodepelatihans';
    protected $fillable = [
        'kode_metodepelatihan',
        'metode_pelatihan',
    ];
}
