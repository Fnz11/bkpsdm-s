<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan3Dokumen;
use App\Models\Pelatihan4Laporan;
use Carbon\Carbon;

class PelatihanTersediaSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('nip')->toArray();
        $dokumenBuffer = collect();
        $adminNIP = '11112';

        for ($i = 1; $i <= 30; $i++) {
            $tersedia = Pelatihan2Tersedia::create([
                'nama_pelatihan' => "Pelatihan Umum $i",
                'jenispelatihan_id' => rand(1, 4),
                'metodepelatihan_id' => rand(1, 3),
                'pelaksanaanpelatihan_id' => rand(1, 3),
                'penyelenggara_pelatihan' => 'Instansi Pelatihan XYZ',
                'tempat_pelatihan' => 'Jakarta',
                'tanggal_mulai' => now()->addDays(rand(1, 30)),
                'tanggal_selesai' => now()->addDays(rand(31, 60)),
                'tutup_pendaftaran' => now()->addDays(rand(1, 15)),
                'kuota' => rand(20, 100),
                'biaya' => rand(1000000, 5000000),
                'deskripsi' => 'Deskripsi pelatihan umum ' . $i,
                'gambar' => null,
                'status_pelatihan' => 'buka',
                'created_at' => Carbon::now(),
            ]);

            for ($j = 0; $j < rand(3, 6); $j++) {
                $userNip = $users[array_rand($users)];
                $statusVerifikasi = ['tersimpan', 'tercetak', 'terkirim', 'diterima', 'ditolak'][rand(0, 4)];
                $statusPeserta = $statusVerifikasi === 'diterima' ? (rand(0, 1) ? 'peserta' : 'alumni') : 'calon_peserta';
                $kode = 'TSP' . $tersedia->id . now()->format('YmdHis') . rand(100, 999);

                // Pastikan tidak duplikat
                while (Pelatihan3Pendaftaran::where('kode_pendaftaran', $kode)->exists()) {
                    $kode = 'TSP' . $tersedia->id . now()->format('YmdHis') . rand(100, 999);
                }

                $pendaftaran = Pelatihan3Pendaftaran::create([
                    'kode_pendaftaran' => $kode,
                    'user_nip' => $userNip,
                    'tersedia_id' => $tersedia->id,
                    'tanggal_pendaftaran' => now()->subDays(rand(0, 10)),
                    'status_verifikasi' => $statusVerifikasi,
                    'status_peserta' => $statusPeserta,
                ]);

                if ($statusVerifikasi === 'terkirim') {
                    $dokumenBuffer->push($pendaftaran);
                }

                // Buat laporan jika peserta atau alumni
                if (in_array($statusPeserta, ['peserta', 'alumni'])) {
                    Pelatihan4Laporan::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'judul_laporan' => 'Laporan ' . $pendaftaran->kode_pendaftaran,
                        'latar_belakang' => 'Latar belakang pelatihan',
                        'sertifikat' => 'uploads/sertifikat/sertifikat_' . $pendaftaran->id . '.pdf',
                        'total_biaya' => rand(1000000, 4000000),
                        'laporan' => 'uploads/laporan/laporan_' . $pendaftaran->id . '.pdf',
                        'hasil_pelatihan' => $statusPeserta === 'peserta' ? 'revisi' : 'lulus',
                    ]);
                }
            }
        }

        // Buat dokumen dari pendaftaran "terkirim"
        $dokumenBuffer = $dokumenBuffer->shuffle()->chunk(10);
        foreach ($dokumenBuffer as $index => $chunk) {
            $dokumen = Pelatihan3Dokumen::create([
                'admin_nip' => $adminNIP,
                'nama_dokumen' => "Dokumen Pelatihan #" . ($index + 1),
                'file_path' => "uploads/dokumen/dokumen_$index.pdf",
                'keterangan' => 'Kumpulan data pendaftaran terkirim',
                'status' => 'diterima',
            ]);

            // Update pendaftaran dengan dokumen_id yang baru dibuat
            Pelatihan3Pendaftaran::whereIn('id', $chunk->pluck('id'))
                ->update(['dokumen_id' => $dokumen->id]);
        }
    }
}
