<?php

namespace Database\Seeders;

use App\Models\Pelatihan1info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihanInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelatihan1Info::create([
            'info_pelatihan' => 'Selamat datang di sistem informasi pelatihan BKPSDM. Silakan daftar untuk pelatihan yang tersedia.',
            'link_pelatihan' => 'https://drive.google.com/info-pelatihan',
            'gambar' => 'uploads/gambar/info-pelatihan.jpg',
        ]);
    }
}
