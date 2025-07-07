<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pbj_1_pelatihan extends Model
{
    use HasFactory;
    protected $fillable = [
       'nip',
       'nama',
       'pangkat_golongan',
       'jabatan',
       'unitkerja',
       'nama_pelatihan',
       'tanggal_mulai',
       'tanggal_selesai',
       'hasil_pelatihan',
       'sertifikat',
    ];
}
