<?php

namespace Database\Seeders;

use App\Models\ref_namapelatihan;
use App\Models\ref_namapelatihans;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RefNamapelatihanSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke file CSV (simpan di storage/app/seeds/namapelatihan.csv)
        $csvPath = storage_path('app/seeds/namapelatihan.csv');
        // Jenis Pelatihan ID
        $jenisId = ['1', '2', '3', '4']; 
        
        if (!File::exists($csvPath)) {
            $this->command->error("File CSV tidak ditemukan: {$csvPath}");
            return;
        }

        $file = fopen($csvPath, 'r');
        
        // Lewati header jika ada
        fgetcsv($file);
        
        $batchSize = 100;
        $data = [];
        $now = Carbon::now();

        while (($row = fgetcsv($file)) !== false) {
            $data[] = [
                'kode_namapelatihan' => $row[0],
                'nama_pelatihan' => $row[1],
                'nip' => '11113',
                'status' => 'diterima',
                'jenispelatihan_id' => $jenisId[array_rand($jenisId)],
                'keterangan' => 'Nama pelatihan diterima',
                'created_at' => $now,
            ];

            // Insert per batch untuk efisiensi
            if (count($data) === $batchSize) {
                ref_namapelatihans::insert($data);
                $data = [];
            }
        }

        // Insert sisa data yang belum terproses
        if (!empty($data)) {
            ref_namapelatihans::insert($data);
        }

        fclose($file);
    }
}