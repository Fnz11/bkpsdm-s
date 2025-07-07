<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eva_1_alumni extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_5_pascadiklat_alumni';
    protected $primaryKey = 'alumni_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nip',
        'nama',
        'pangkat',
        'golongan',
        'jabatan',
        'unit_kerja',
        'nama_pelatihan',
        'jenis_pelatihan',
        'nip_atasan',
        'nama_atasan',
        'nip_rekankerja',
        'nama_rekankerja',
    ];
}

