<?php

namespace Database\Seeders;

use App\Models\ref_jenisasns;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefjenisasnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        ref_jenisasns::insert([
            [
                'kode_jenisasn' => 'JA001',
                'jenis_asn' => 'PNS',
                'created_at' => $now,
            ],
            [
                'kode_jenisasn' => 'JA002',
                'jenis_asn' => 'PPPK',
                'created_at' => $now,
            ],
        ]);
    }
}
