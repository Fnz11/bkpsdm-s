<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brosur_1_info extends Model
{
      //
      use HasFactory;
      protected $fillable = [
          'info_brosur',
          'link_brosur',
          'gambar',
      ];
}
