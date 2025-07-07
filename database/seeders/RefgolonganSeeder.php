<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RefGolonganSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::parse('2025-05-05 22:39:58');

        $data = [
            ['PNS001', 1, 'IV/e', 'Pembina Utama', 'Pembina Utama (IV/e)'],
            ['PNS002', 1, 'IV/d', 'Pembina Utama Madya', 'Pembina Utama Madya (IV/d)'],
            ['PNS003', 1, 'IV/c', 'Pembina Utama Muda', 'Pembina Utama Muda (IV/c)'],
            ['PNS004', 1, 'IV/b', 'Pembina Tk. I', 'Pembina Tk. I (IV/b)'],
            ['PNS005', 1, 'IV/a', 'Pembina', 'Pembina (IV/a)'],
            ['PNS006', 1, 'III/d', 'Penata Tk. I', 'Penata Tk. I (III/d)'],
            ['PNS007', 1, 'III/c', 'Penata', 'Penata (III/c)'],
            ['PNS008', 1, 'III/b', 'Penata Muda Tk. I', 'Penata Muda Tk. I (III/b)'],
            ['PNS009', 1, 'III/a', 'Penata Muda', 'Penata Muda (III/a)'],
            ['PNS010', 1, 'II/d', 'Pengatur Tk. I', 'Pengatur Tk. I (II/d)'],
            ['PNS011', 1, 'II/c', 'Pengatur', 'Pengatur (II/c)'],
            ['PNS012', 1, 'II/b', 'Pengatur Muda Tk. I', 'Pengatur Muda Tk. I (II/b)'],
            ['PNS013', 1, 'II/a', 'Pengatur Muda', 'Pengatur Muda (II/a)'],
            ['PNS014', 1, 'I/d', 'Juru Tk. I', 'Juru Tk. I (I/d)'],
            ['PNS015', 1, 'I/c', 'Juru', 'Juru (I/c)'],
            ['PNS016', 1, 'I/b', 'Juru Muda Tk. I', 'Juru Muda Tk. I (I/b)'],
            ['PNS017', 1, 'I/a', 'Juru Muda', 'Juru Muda (I/a)'],
            ['PPPK001', 2, 'XVII', '-', 'XVII'],
            ['PPPK002', 2, 'XVI', '-', 'XVI'],
            ['PPPK003', 2, 'XV', '-', 'XV'],
            ['PPPK004', 2, 'XIV', '-', 'XIV'],
            ['PPPK005', 2, 'XIII', '-', 'XIII'],
            ['PPPK006', 2, 'XII', '-', 'XII'],
            ['PPPK007', 2, 'XI', '-', 'XI'],
            ['PPPK008', 2, 'X', '-', 'X'],
            ['PPPK009', 2, 'IX', '-', 'IX'],
            ['PPPK010', 2, 'VIII', '-', 'VIII'],
            ['PPPK011', 2, 'VII', '-', 'VII'],
            ['PPPK012', 2, 'VI', '-', 'VI'],
            ['PPPK013', 2, 'V', '-', 'V'],
            ['PPPK014', 2, 'IV', '-', 'IV'],
            ['PPPK015', 2, 'III', '-', 'III'],
            ['PPPK016', 2, 'II', '-', 'II'],
            ['PPPK017', 2, 'I', '-', 'I'],
        ];

        foreach ($data as $item) {
            DB::table('ref_golongans')->insert([
                'kode_golongan'    => $item[0],
                'jenisasn_id'      => $item[1],
                'golongan'         => $item[2],
                'pangkat'          => $item[3],
                'pangkat_golongan' => $item[4],
                'created_at'       => $now,
            ]);
        }
    }
}
