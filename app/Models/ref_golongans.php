<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_golongans extends Model
{
    use HasFactory;
    protected $table = 'ref_golongans'; // Pastikan tabel sesuai dengan database
    protected $fillable = [
       'kode_golongan',
       'jenisasn_id',
       'golongan',
       'pangkat',
       'pangkat_golongan',
    ];

    protected $with = [
        'jenisasn',
    ];

    public function jenisasn()
    {
        return $this->belongsTo(ref_jenisasns::class, 'jenisasn_id');
    }
    
    public function user_pivot()
    {
        return $this->hasMany(UserPivot::class, 'id_golongan', 'id');
    }
}
