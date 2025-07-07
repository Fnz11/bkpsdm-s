<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solowasis_1_info extends Model
{
    use HasFactory;
    protected $fillable = [
        'info_solowasis',
        'gambar_solowasis',
        'link_solowasis',
        'keterangan',
    ];
}
