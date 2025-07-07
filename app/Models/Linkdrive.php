<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Linkdrive extends Model
{
    use HasFactory;
    protected $fillable = ['tahun','linkdrive','keterangan'];
}
