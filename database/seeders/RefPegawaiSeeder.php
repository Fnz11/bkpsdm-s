<?php

namespace Database\Seeders;

use App\Models\RefPegawai;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RefPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = storage_path('app/seeds/ref_pegawais.csv');

        if (!File::exists($csvPath)) {
            $this->command->error("File CSV tidak ditemukan: {$csvPath}");
            return;
        }

        $file = fopen($csvPath, 'r');
        fgetcsv($file); // skip header

        $batchSize = 100;
        $data = [];
        $now = Carbon::now();

        // Atasan untuk masing-masing unit kerja
        $atasanUnitKerja = [
            19 => '199908282023081001', // Dinas Kesehatan - ABDULLAH FATAH
            26 => '198007022003121004', // Kecamatan Banjarsari - AGUNG WIJAYANTO
            27 => '197711112003121013', // Kecamatan Jebres - ANDY PURWANTO
        ];

        while (($row = fgetcsv($file)) !== false) {
            $nip = $row[1];
            
            // Tentukan atasan berdasarkan unit kerja
            $unitKerjaId = $this->getUnitKerjaForPegawai($nip);
            $nipAtasan = $atasanUnitKerja[$unitKerjaId] ?? null;

            $data[] = [
                'nip' => $nip,
                'name' => $row[3] ?? 'Nama belum diisi',
                'foto' => 'default.jpg',
                'alamat' => $row[10] ?? 'Alamat belum diisi',
                'no_hp' => is_numeric($row[13]) ? $row[13] : 0,
                'nip_atasan' => $nipAtasan,
                'tempat_lahir' => 'Surakarta',
                'tanggal_lahir' => now(),
                'created_at' => $now,
            ];

            if (count($data) === $batchSize) {
                RefPegawai::insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            RefPegawai::insert($data);
        }

        fclose($file);
    }

    private function getUnitKerjaForPegawai($nip): int
    {
        // Logika pembagian pegawai ke unit kerja
        $unitKerjaMapping = [
            19 => ['199908282023081001', '199808282022081001', '199706162022032013', '198405272006042009', 
                  '199409182017081001', '198911272013101001', '197310082014062002', '199011102024211008'],
            26 => ['198007022003121004', '198504252003122001', '197712242005011006', '198206262008011005',
                  '199708302022032012', '199309152023211008', '199303232023211029'],
            27 => ['197711112003121013', '198201012006041019', '198112252009042003', '198812192010012005',
                  '199712282020122006', '199512192018082001', '199604122020122018']
        ];

        foreach ($unitKerjaMapping as $unitId => $nips) {
            if (in_array($nip, $nips)) {
                return $unitId;
            }
        }

        return 19; // Default ke Dinas Kesehatan
    }
}