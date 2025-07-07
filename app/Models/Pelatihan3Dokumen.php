<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan3Dokumen extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_3_dokumens';
    protected $fillable = [
        'admin_nip',
        'nama_dokumen',
        'file_path',
        'tanggal_upload',
        'keterangan',
        'status',
    ];

    // protected $with = [
    //     'pendaftarans',
    // ];

    // Relasi ke pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pelatihan3Pendaftaran::class, 'dokumen_id');
    }


    // Relasi ke admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_nip', 'nip');
    }
}
