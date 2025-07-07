<?php

namespace Database\Seeders;

use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan4Laporan;
use Illuminate\Database\Seeder;

class PelatihanLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendaftarans = Pelatihan3Pendaftaran::where('status_verifikasi', 'diterima')
            ->where('status_peserta', 'peserta')
            ->get();

        foreach ($pendaftarans as $p) {
            Pelatihan4Laporan::create([
                'pendaftaran_id' => $p->id,
                'judul_laporan' => 'Laporan ' . $p->kode_pendaftaran,
                'latar_belakang' => 'Latar belakang pelatihan',
                'sertifikat' => 'sertifikat_' . $p->id . '.pdf',
                'total_biaya' => rand(1000000, 4000000),
                'laporan' => 'uploads/laporan/laporan_' . $p->id . '.pdf',
                'hasil_pelatihan' => ['lulus', 'tidak_lulus', 'revisi'][rand(0, 2)],
            ]);
        }
    }
}
