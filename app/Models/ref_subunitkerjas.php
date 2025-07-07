<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_subunitkerjas extends Model
{
    use HasFactory;
    protected $table = 'ref_subunitkerjas'; // Nama tabel di database
    protected $fillable = [
        'unitkerja_id', // Foreign key untuk relasi dengan ref_unitkerjas
        'sub_unitkerja',
        'singkatan',
    ];
    protected $with = ['unitkerja'];

    public function unitkerja()
    {
        return $this->belongsTo(ref_unitkerjas::class, 'unitkerja_id', 'id');
    }

    public function user_pivot()
    {
        return $this->hasMany(UserPivot::class, 'id_subunitkerja', 'id');
    }
}
