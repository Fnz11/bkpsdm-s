<?php

namespace Database\Seeders;

use App\Models\Pelatihan3PivotDokDaf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihanPivotDokDafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pivot = [
            ['dokumen_id' => 1, 'pendaftaran_id' => 1],
            ['dokumen_id' => 2, 'pendaftaran_id' => 1],
            ['dokumen_id' => 1, 'pendaftaran_id' => 2],
            ['dokumen_id' => 2, 'pendaftaran_id' => 2],
        ];

        Pelatihan3PivotDokDaf::insert($pivot);
    }
}
