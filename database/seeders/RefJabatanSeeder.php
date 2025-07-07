<?php

namespace Database\Seeders;

use App\Models\ref_jabatans;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RefJabatanSeeder extends Seeder
{
    public function run()
    {
        // Get all kategori jabatan first to map the names to IDs
        $kategoris = DB::table('ref_kategorijabatans')->get();
        $kategoriMap = [];
        foreach ($kategoris as $kategori) {
            $kategoriMap[$kategori->kategori_jabatan] = $kategori->id;
        }


        // Path ke file CSV
        $csvPath = storage_path('app/seeds/ref_namajabatanasns.csv');

        if (!File::exists($csvPath)) {
            $this->command->error("File CSV tidak ditemukan: {$csvPath}");
            return;
        }

        $file = fopen($csvPath, 'r');

        // Lewati header
        fgetcsv($file);

        $data = [];
        $batchSize = 100;
        $now = Carbon::now();

        while (($row = fgetcsv($file)) !== false) {
            $data[] = [
                'kategorijabatan_id' => $row[2],
                'jabatan' => $row[1],
                'created_at' => $now,
            ];

            // Insert batch
            if (count($data) === $batchSize) {
                ref_jabatans::insert($data);
                $data = [];
            }
        }

        // Insert sisa data
        if (!empty($data)) {
            ref_jabatans::insert($data);
        }

        fclose($file);

        DB::table('ref_jabatan')->insert([
            [
                'jabatan' => 'Kepala Subbagian Umum',
                'jenis_jabatan' => 'Struktural',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan' => 'Analis Kepegawaian',
                'jenis_jabatan' => 'Fungsional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan' => 'Staf Administrasi',
                'jenis_jabatan' => 'Pelaksana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
