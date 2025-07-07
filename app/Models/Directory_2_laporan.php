<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory_2_laporan extends Model
{
    //
use HasFactory;

protected $fillable = [
'nip',
'nama',
'golongan_ruang',
'jabatan',
'unit_kerja',
'email',
'foto',
'nama_pelatihan',
'pelaksanaan_pelatihan',
'jenis_pelatihan',
'metode_pelatihan',
'rumpun_pelatihan',
'penyelenggara_pelatihan',
'tanggal_mulai',
'tanggal_selesai',
'hasil_pelatihan',
'sertifikat',
'judul_laporan',
'abstrak_laporan',
'link_laporan',
'Status_peserta',
'keterangan',
    ];
}
