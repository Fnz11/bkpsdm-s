<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipasn_1_info extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tanggal_penetapan',
        'nilai',
        'link_bkn',
        'link_bkpsdm',
    ];



}
