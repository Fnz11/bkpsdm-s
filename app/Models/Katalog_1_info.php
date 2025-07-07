<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog_1_info extends Model
{
      //
      use HasFactory;
      protected $fillable = [
          'info_katalog',
          'link_info',
          'gambar',
      ];
}
