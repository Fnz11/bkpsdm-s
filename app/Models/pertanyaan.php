<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_5_pertanyaan';

    protected $fillable = [
        'kode_jenispelatihan',
        'kode_kategoripertanyaan',
        'pertanyaan',
    ];
}
