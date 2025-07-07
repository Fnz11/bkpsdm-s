<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jenisasns extends Model
{
    use HasFactory;
    protected $table = 'ref_jenisasns'; // Pastikan tabel sesuai dengan database
    protected $fillable = [
       'kode_jenisasn',
       'jenis_asn',
    ];

    public function golongan()
    {
        return $this->hasMany(ref_golongans::class, 'jenisasn_id', 'id');
    }
}
