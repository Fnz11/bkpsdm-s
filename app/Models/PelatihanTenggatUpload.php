<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanTenggatUpload extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_tenggat_upload';

    protected $fillable = [
        'tersedia_id',
        'pendaftaran_id',
        'tahun',
        'jenis_deadline',
        'tanggal_mulai',
        'tanggal_deadline',
        'keterangan',
    ];

    /**
     * Relasi ke pelatihan tersedia (jika berlaku global)
     */
    public function pelatihanTersedia()
    {
        return $this->belongsTo(Pelatihan2Tersedia::class, 'tersedia_id');
    }

    /**
     * Relasi ke pendaftaran pelatihan usulan (jika berlaku individual)
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pelatihan3Pendaftaran::class, 'pendaftaran_id');
    }

    /**
     * Scope: filter berdasarkan jenis deadline
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_deadline', $jenis);
    }

    /**
     * Scope: filter aktif (deadline belum lewat)
     */
    public function scopeAktif($query)
    {
        return $query->where('tanggal_deadline', '>=', now());
    }

    /**
     * Validasi internal: pastikan hanya satu dari tersedia_id atau pendaftaran_id yang terisi
     */
    public function isValidRelasi()
    {
        return ($this->tersedia_id && !$this->pendaftaran_id) ||
            (!$this->tersedia_id && $this->pendaftaran_id);
    }
}
