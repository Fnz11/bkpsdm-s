<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan3Dokumen;
use App\Models\Pelatihan4Laporan;

class PelatihanUsulanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('nip')->toArray();
        $dokumenBuffer = collect();
        $adminNIP = '11112';

        for ($i = 1; $i <= 30; $i++) {
            $nip = $users[array_rand($users)];

            $usulan = Pelatihan2Usulan::create([
                'nip_pengusul' => $nip,
                'nama_pelatihan' => "Usulan Pelatihan $i",
                'jenispelatihan_id' => rand(1, 4),
                'metodepelatihan_id' => rand(1, 3),
                'pelaksanaanpelatihan_id' => rand(1, 3),
                'penyelenggara_pelatihan' => 'Pihak Ketiga A',
                'tempat_pelatihan' => 'Surabaya',
                'tanggal_mulai' => now()->addDays(rand(1, 30)),
                'tanggal_selesai' => now()->addDays(rand(31, 60)),
                'file_penawaran' => 'uploads/penawaran/file_penawaran.pdf',
                'keterangan' => 'Usulan pelatihan ke-' . $i,
                'estimasi_biaya' => rand(1000000, 4000000),
            ]);

            $statusVerifikasi = ['tersimpan', 'tercetak', 'terkirim', 'diterima', 'ditolak'][rand(0, 3)];
            $statusPeserta = $statusVerifikasi === 'diterima' ? (rand(0, 1) ? 'peserta' : 'alumni') : 'calon_peserta';

            $pendaftaran = Pelatihan3Pendaftaran::create([
                'kode_pendaftaran' => 'USP' . $usulan->id . now()->format('YmdHis'),
                'user_nip' => $nip,
                'usulan_id' => $usulan->id,
                'tanggal_pendaftaran' => now(),
                'status_verifikasi' => $statusVerifikasi,
                'status_peserta' => $statusPeserta,
            ]);

            if ($statusVerifikasi === 'terkirim') {
                $dokumenBuffer->push($pendaftaran);
            }

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

        $dokumenBuffer = $dokumenBuffer->shuffle()->chunk(10);
        foreach ($dokumenBuffer as $index => $chunk) {
            $dokumen = Pelatihan3Dokumen::create([
                'admin_nip' => $adminNIP,
                'nama_dokumen' => "Dokumen Usulan #" . ($index + 1),
                'file_path' => "uploads/dokumen/usulan_dokumen_$index.pdf",
                'keterangan' => 'Dokumen otomatis dari usulan',
                'status' => 'diterima',
            ]);

            // Update pendaftaran dengan dokumen_id yang baru dibuat
            Pelatihan3Pendaftaran::whereIn('id', $chunk->pluck('id'))
                ->update(['dokumen_id' => $dokumen->id]);
        }
    }
}
