<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_pegawais extends Model
{
    use HasFactory;

    protected $table = 'ref_pegawais'; // Pastikan tabel sesuai dengan database
    protected $primaryKey = 'nip'; // Jika NIP adalah primary key
    public $incrementing = false; // Jika primary key bukan auto-increment
    protected $fillable = [
        'nip',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'pangkat',
        'golongan',
        'jabatan',
        'unit_kerja',
        'no_wa',
        'email',
        'alamat',
        'foto',
        'role'
    ];
}
