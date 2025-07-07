<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPivot extends Model
{
    use HasFactory;

    protected $table = 'user_pivot';

    protected $fillable = [
        'nip',
        'id_unitkerja',
        'id_golongan',
        'id_jabatan',
        'tgl_mulai',
        'tgl_akhir',
        'is_unit_kerja',
        'is_jabatan',
        'is_golongan',
        'is_active'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function unitKerja() {
        return $this->belongsTo(ref_subunitkerjas::class, 'id_unitkerja');
    }

    public function golongan() {
        return $this->belongsTo(ref_golongans::class, 'id_golongan');
    }

    public function jabatan() {
        return $this->belongsTo(ref_jabatans::class, 'id_jabatan');
    }
}
