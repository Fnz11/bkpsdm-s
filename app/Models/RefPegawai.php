<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPegawai extends Model
{
    use HasFactory;

    protected $table = 'ref_pegawai';

    protected $fillable = [
        'nip',
        'name',
        'foto',
        'alamat',
        'no_hp',
        'nip_atasan',
        'tempat_lahir',
        'tanggal_lahir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tgl_mulai' => 'date',
        // tambahkan kolom tanggal lainnya jika ada
    ];    

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'nip_atasan', 'nip');
    }
}
