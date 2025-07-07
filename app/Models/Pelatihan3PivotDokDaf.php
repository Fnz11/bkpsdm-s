<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan3PivotDokDaf extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_3_pivot_dokdaf';
    protected $fillable = [
        'pendaftaran_id',
        'dokumen_id',
    ];

    // protected $with = [
    //     'pendaftaran',
    //     'dokumen',
    // ];
    
    // Relasi ke pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pelatihan3Pendaftaran::class, 'pendaftaran_id', 'id');
    }

    // Relasi ke dokumen
    public function dokumen()
    {
        return $this->belongsTo(Pelatihan3Dokumen::class, 'dokumen_id', 'id');
    }
}
