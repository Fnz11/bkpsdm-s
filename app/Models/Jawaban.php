<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'pelatihan_5_jawaban_alumni';

    protected $fillable = [
        'alumni_id',
        'pertanyaan_index',
        'jawaban',
    ];

    public function alumni()
    {
        return $this->belongsTo(Eva1Alumni::class, 'alumni_id');
    }
}
