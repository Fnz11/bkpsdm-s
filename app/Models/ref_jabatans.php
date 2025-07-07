<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jabatans extends Model
{
    use HasFactory;
    protected $table = 'ref_jabatans';
    protected $fillable = [
        'kategorijabatan_id',
        'jabatan',
    ];
    protected $with = ['kategorijabatan'];

    public function user_pivot()
    {
        return $this->hasMany(UserPivot::class, 'id_jabatan', 'id');
    }

    public function kategorijabatan()
    {
        return $this->belongsTo(ref_kategorijabatans::class, 'kategorijabatan_id');
    }
}
