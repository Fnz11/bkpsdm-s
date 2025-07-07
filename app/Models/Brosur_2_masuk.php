<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brosur_2_masuk extends Model
{
     //
     use HasFactory;
     protected $fillable = [
        'nama_penyelenggara',
        'alamat',
        'nama_sales',
        'no_hp',
        'no_surat',
        'tanggal_surat',
        'brosur_excel',
        'brosur_pdf',
        'status',
     ];
}
