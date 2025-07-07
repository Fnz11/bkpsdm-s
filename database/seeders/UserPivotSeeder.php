<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPivotSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = DB::table('ref_pegawai')->pluck('nip');

        if ($pegawais->isEmpty()) {
            $this->command->warn('ref_pegawai kosong, tidak ada data untuk user_pivot.');
            return;
        }

        $golonganIds = DB::table('ref_golongans')->pluck('id');
        $jabatanIds = DB::table('ref_jabatans')->pluck('id');

        if ($golonganIds->isEmpty() || $jabatanIds->isEmpty()) {
            $this->command->warn('Data referensi golongan / jabatan kosong.');
            return;
        }

        $data = [];

        foreach ($pegawais as $nip) {
            $unitKerjaId = $this->getUnitKerjaForPegawai($nip);
            $subUnitKerjaId = DB::table('ref_subunitkerjas')
                ->where('unitkerja_id', $unitKerjaId)
                ->inRandomOrder()
                ->value('id'); // Ambil satu ID acak

            $data[] = [
                'nip' => $nip,
                'id_unitkerja' => $subUnitKerjaId,
                'id_golongan' => $golonganIds->random(),
                'id_jabatan' => $jabatanIds->random(),
                'tgl_mulai' => now()->subYears(rand(1, 3))->startOfYear()->format('Y-m-d'),
                'tgl_akhir' => now()->addYears(rand(1, 2))->endOfYear()->format('Y-m-d'),
                'is_unit_kerja' => true,
                'is_jabatan' => true,
                'is_golongan' => true,
                'is_active' => true,
                'created_at' => now(),
            ];
        }

        DB::table('user_pivot')->insert($data);
        $this->command->info(count($data) . ' data user_pivot berhasil dimasukkan.');
    }

    private function getUnitKerjaForPegawai($nip): int
    {
        // Sesuaikan dengan mapping yang sama di RefPegawaiSeeder
        $unitKerjaMapping = [
            19 => [
                '199908282023081001',
                '199808282022081001',
                '199706162022032013',
                '198405272006042009',
                '199409182017081001',
                '198911272013101001',
                '197310082014062002',
                '199011102024211008'
            ],
            26 => [
                '198007022003121004',
                '198504252003122001',
                '197712242005011006',
                '198206262008011005',
                '199708302022032012',
                '199309152023211008',
                '199303232023211029'
            ],
            27 => [
                '197711112003121013',
                '198201012006041019',
                '198112252009042003',
                '198812192010012005',
                '199712282020122006',
                '199512192018082001',
                '199604122020122018'
            ]
        ];

        foreach ($unitKerjaMapping as $unitId => $nips) {
            if (in_array($nip, $nips)) {
                return $unitId;
            }
        }

        return 19; // Default ke Dinas Kesehatan
    }
}
