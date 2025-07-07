<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_unitkerjas extends Model
{
    use HasFactory;
    protected $table = 'ref_unitkerjas';

    protected $fillable = [
        'kode_unitkerja',
        'unitkerja',
    ];

    public function subunitkerjas()
    {
        return $this->hasMany(ref_subunitkerjas::class, 'unitkerja_id', 'id');
    }
}
