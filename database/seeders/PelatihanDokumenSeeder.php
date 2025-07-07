<?php

namespace Database\Seeders;

use App\Models\Pelatihan3Dokumen;
use App\Models\Pelatihan3Pendaftaran;
use Illuminate\Database\Seeder;

class PelatihanDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendaftarans = Pelatihan3Pendaftaran::all()->shuffle();
        $chunks = $pendaftarans->chunk(10); // 1 dokumen = 10 pendaftaran
        $adminNIP = '11112'; // Ganti dengan NIP admin yang valid

        foreach ($chunks as $index => $chunk) {
            $dokumen = Pelatihan3Dokumen::create([
                'admin_nip' => $adminNIP,
                'nama_dokumen' => "Dokumen Pelatihan #" . ($index + 1),
                'file_path' => "uploads/dokumen/dokumen_$index.pdf",
                'keterangan' => 'Kumpulan data pendaftaran',
                'status' => 'diterima',
            ]);

            // Update pendaftaran dengan dokumen_id yang baru dibuat
            Pelatihan3Pendaftaran::whereIn('id', $chunk->pluck('id'))
                ->update(['dokumen_id' => $dokumen->id]);
        }
    }
}
