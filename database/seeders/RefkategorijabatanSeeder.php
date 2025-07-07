<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefKategorijabatanSeeder extends Seeder
{
    public function run()
    {
        $kategorijabatans = [
            [
                'kode_kategorijabatan' => 'KJ001',
                'kategori_jabatan' => 'Esselon II',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ002',
                'kategori_jabatan' => 'Esselon III',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ003',
                'kategori_jabatan' => 'Esselon IV',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ004',
                'kategori_jabatan' => 'Pelaksana',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ005',
                'kategori_jabatan' => 'Fungsional Teknis',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ006',
                'kategori_jabatan' => 'Fungsional Kesehatan',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ007',
                'kategori_jabatan' => 'Fungsional Pendidik',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ008',
                'kategori_jabatan' => 'Administrator',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ009',
                'kategori_jabatan' => 'Pengawas',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ010',
                'kategori_jabatan' => 'Staf Khusus',
                'created_at' => now(),
            ],
            [
                'kode_kategorijabatan' => 'KJ011',
                'kategori_jabatan' => 'Staf Ahli',
                'created_at' => now(),
            ],
        ];

        DB::table('ref_kategorijabatans')->insert($kategorijabatans);
    }
}