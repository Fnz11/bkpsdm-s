<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipasn_3_nilaiperasn extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun',
        'nip',
        'nama',
        'jabatan',
        'unit_kerja',
        'nilai_pendidikan',
        'nilai_kinerja',
        'nilai_disiplin',
        'nilai_bangkom',
        'nilai_totalipasn',
        'link_filepenetapanbkd',
    ];    


   

}
