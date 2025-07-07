<?php

namespace Database\Seeders;

use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Dokumen;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihanPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('nip')->toArray();
        $tersedias = Pelatihan2Tersedia::inRandomOrder()->limit(8)->get();

        foreach ($tersedias as $tersedia) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                $userNip = $users[array_rand($users)];

                $statusVerifikasi = ['tersimpan', 'terkirim', 'diterima', 'ditolak'][rand(0, 3)];
                $statusPeserta = 'pendaftar';

                if ($statusVerifikasi === 'diterima') {
                    $statusPeserta = 'peserta';
                }

                // jika bukan diterima maka status peserta tetap pendaftar
                if (in_array($statusVerifikasi, ['tersimpan', 'terkirim', 'ditolak']) && $statusPeserta !== 'pendaftar') {
                    $statusPeserta = 'pendaftar';
                }

                $pendaftaran = Pelatihan3Pendaftaran::create([
                    'kode_pendaftaran' => 'TSP' . $tersedia->id . now()->format('YmdHis') . rand(100, 999),
                    'user_nip' => $userNip,
                    'tersedia_id' => $tersedia->id,
                    'tanggal_pendaftaran' => now()->subDays(rand(0, 10)),
                    'status_verifikasi' => $statusVerifikasi,
                    'status_peserta' => $statusPeserta,
                ]);

                // relasi ke dokumen jika terkirim
                if ($statusVerifikasi === 'terkirim') {
                    $dokumen = Pelatihan3Dokumen::inRandomOrder()->first();
                    if ($dokumen) {
                        $dokumen->pendaftarans()->attach($pendaftaran->id);
                    }
                }
            }
        }
    }
}
