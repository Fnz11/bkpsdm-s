<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan1Info extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_1_infos';
    protected $fillable = [
        'info_pelatihan',
        'link_pelatihan',
        'gambar',
    ];
}
