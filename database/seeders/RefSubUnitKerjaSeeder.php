<?php

namespace Database\Seeders;

use App\Models\ref_subunitkerja;
use App\Models\ref_subunitkerjas;
use Illuminate\Database\Seeder;

class RefSubUnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $subunits = [
            // Badan Perencanaan Pembangunan Daerah (id:1)
            ['unitkerja_id' => 1, 'sub_unitkerja' => 'Badan Perencanaan Pembangunan Daerah', 'singkatan' => 'BAPPEDA'],
            
            // Badan Kepegawaian dan Pengembangan SDM (id:2)
            ['unitkerja_id' => 2, 'sub_unitkerja' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'singkatan' => 'BKPSDM'],
            
            // Badan Penanggulangan Bencana Daerah (id:3)
            ['unitkerja_id' => 3, 'sub_unitkerja' => 'Badan Penanggulangan Bencana Daerah', 'singkatan' => 'BPBD'],
            
            // Badan Pengelolaan Keuangan dan Aset Daerah (id:4)
            ['unitkerja_id' => 4, 'sub_unitkerja' => 'Badan Pengelolaan Keuangan dan Aset Daerah', 'singkatan' => 'BPKAD'],
            ['unitkerja_id' => 4, 'sub_unitkerja' => 'UPTD Pengelolaan Aset Daerah', 'singkatan' => 'UPTD PAD'],
            
            // Badan Riset dan Inovasi Daerah (id:5)
            ['unitkerja_id' => 5, 'sub_unitkerja' => 'Badan Riset dan Inovasi Daerah', 'singkatan' => 'BRID'],
            ['unitkerja_id' => 5, 'sub_unitkerja' => 'UPTD Kawasan Sains dan Teknologi Solo Technopark', 'singkatan' => 'UPTD Solo Technopark'],
            
            // Dinas Pemadam Kebakaran (id:6)
            ['unitkerja_id' => 6, 'sub_unitkerja' => 'Dinas Pemadam Kebakaran', 'singkatan' => 'DAMKAR'],
            
            // Dinas Koperasi UKM dan Perindustrian (id:7)
            ['unitkerja_id' => 7, 'sub_unitkerja' => 'Dinas Koperasi Usaha Kecil dan Menengah dan Perindustrian', 'singkatan' => 'DISKOPUKM-PERIN'],
            ['unitkerja_id' => 7, 'sub_unitkerja' => 'UPTD Pengelolaan Sentra Industri Kecil Menengah', 'singkatan' => 'UPTD SENTRA IKM'],
            
            // Dinas Sosial (id:8)
            ['unitkerja_id' => 8, 'sub_unitkerja' => 'Dinas Sosial', 'singkatan' => 'DINSOS'],
            
            // Dinas Kebudayaan dan Pariwisata (id:9)
            ['unitkerja_id' => 9, 'sub_unitkerja' => 'Dinas Kebudayaan dan Pariwisata', 'singkatan' => 'DISBUDPAR'],
            ['unitkerja_id' => 9, 'sub_unitkerja' => 'UPTD Kawasan Wisata', 'singkatan' => 'UPTD KAWIS'],
            ['unitkerja_id' => 9, 'sub_unitkerja' => 'UPTD Museum', 'singkatan' => 'UPTD MUSEUM'],
            
            // Dinas Perdagangan (id:10)
            ['unitkerja_id' => 10, 'sub_unitkerja' => 'Dinas Perdagangan', 'singkatan' => 'DISDAG'],
            ['unitkerja_id' => 10, 'sub_unitkerja' => 'UPTD Metrologi Legal', 'singkatan' => 'UPTD METROLOGI'],
            
            // Dinas Pendidikan (id:11)
            ['unitkerja_id' => 11, 'sub_unitkerja' => 'Dinas Pendidikan', 'singkatan' => 'DISDIK'],
            ['unitkerja_id' => 11, 'sub_unitkerja' => 'UPTD PLDPI', 'singkatan' => 'UPTD PLDPI'],
            
            // Dinas Perhubungan (id:12)
            ['unitkerja_id' => 12, 'sub_unitkerja' => 'Dinas Perhubungan', 'singkatan' => 'DISHUB'],
            ['unitkerja_id' => 12, 'sub_unitkerja' => 'UPTD Pengelolaan Perparkiran', 'singkatan' => 'UPTD PARKIR'],
            ['unitkerja_id' => 12, 'sub_unitkerja' => 'UPTD Transportasi', 'singkatan' => 'UPTD TRANSPORTASI'],
            
            // Dinas Kominfo, Statistik dan Persandian (id:13)
            ['unitkerja_id' => 13, 'sub_unitkerja' => 'Dinas Komunikasi, Informatika, Statistik dan Persandian', 'singkatan' => 'DISKOMINFO'],
            
            // Dinas Tenaga Kerja (id:14)
            ['unitkerja_id' => 14, 'sub_unitkerja' => 'Dinas Tenaga Kerja', 'singkatan' => 'DISNAKER'],
            
            // Dinas Kependudukan dan Pencatatan Sipil (id:15)
            ['unitkerja_id' => 15, 'sub_unitkerja' => 'Dinas Kependudukan dan Pencatatan Sipil', 'singkatan' => 'DISDUKCAPIL'],
            
            // Dinas Perpustakaan dan Kearsipan (id:16)
            ['unitkerja_id' => 16, 'sub_unitkerja' => 'Dinas Perpustakaan dan Kearsipan', 'singkatan' => 'DISPUSIP'],
            
            // Dinas Perumahan dan Kawasan Permukiman (id:17)
            ['unitkerja_id' => 17, 'sub_unitkerja' => 'Dinas Perumahan dan Kawasan Permukiman serta Pertanahan', 'singkatan' => 'DISPERKIMTAN'],
            ['unitkerja_id' => 17, 'sub_unitkerja' => 'UPTD Rumah Sewa', 'singkatan' => 'UPTD RUSEWA'],
            
            // Dinas Kepemudaan dan Olahraga (id:18)
            ['unitkerja_id' => 18, 'sub_unitkerja' => 'Dinas Kepemudaan dan Olahraga', 'singkatan' => 'DISPORA'],
            
            // Dinas Kesehatan (id:19)
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Dinas Kesehatan', 'singkatan' => 'DINKES'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Banyuanyar', 'singkatan' => 'PUSKESMAS BANYUANYAR'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Gajahan', 'singkatan' => 'PUSKESMAS GAJAHAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Gambirsari', 'singkatan' => 'PUSKESMAS GAMBIRSARI'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Gilingan', 'singkatan' => 'PUSKESMAS GILINGAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Jayengan', 'singkatan' => 'PUSKESMAS JAYENGAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Kratonan', 'singkatan' => 'PUSKESMAS KRATONAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Manahan', 'singkatan' => 'PUSKESMAS MANAHAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Ngoresan', 'singkatan' => 'PUSKESMAS NGORESAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Nusukan', 'singkatan' => 'PUSKESMAS NUSUKAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Pajang', 'singkatan' => 'PUSKESMAS PAJANG'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Penumping', 'singkatan' => 'PUSKESMAS PENUMPING'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Pucangsawit', 'singkatan' => 'PUSKESMAS PUCANGSAWIT'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Purwodiningratan', 'singkatan' => 'PUSKESMAS PURWODININGRATAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Purwosari', 'singkatan' => 'PUSKESMAS PURWOSARI'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Sangkrah', 'singkatan' => 'PUSKESMAS SANGKRAH'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Setabelan', 'singkatan' => 'PUSKESMAS SETABELAN'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'Puskesmas Sibela', 'singkatan' => 'PUSKESMAS SIBELA'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'UPTD Instalasi Farmasi', 'singkatan' => 'UPTD INAFAR'],
            ['unitkerja_id' => 19, 'sub_unitkerja' => 'UPTD Laboratorium Kesehatan', 'singkatan' => 'UPTD LABKES'],
            
            // Dinas Ketahanan Pangan dan Pertanian (id:20)
            ['unitkerja_id' => 20, 'sub_unitkerja' => 'Dinas Ketahanan Pangan dan Pertanian', 'singkatan' => 'DKPP'],
            ['unitkerja_id' => 20, 'sub_unitkerja' => 'UPTD Aneka Usaha Perikanan', 'singkatan' => 'UPTD PERIKANAN'],
            ['unitkerja_id' => 20, 'sub_unitkerja' => 'UPTD RPH dan Puskeswan', 'singkatan' => 'UPTD RPH-PUSKESWAN'],
            
            // Dinas Lingkungan Hidup (id:21)
            ['unitkerja_id' => 21, 'sub_unitkerja' => 'Dinas Lingkungan Hidup', 'singkatan' => 'DLH'],
            ['unitkerja_id' => 21, 'sub_unitkerja' => 'UPTD Pengelolaan TPA Sampah', 'singkatan' => 'UPTD TPA'],
            
            // Dinas Penanaman Modal dan PTSP (id:22)
            ['unitkerja_id' => 22, 'sub_unitkerja' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'singkatan' => 'DPM-PTSP'],
            
            // Dinas Pemberdayaan Perempuan dan PPKB (id:23)
            ['unitkerja_id' => 23, 'sub_unitkerja' => 'Dinas Pemberdayaan Perempuan dan Pelindungan Anak serta Pengendalian Penduduk dan Keluarga Berencana', 'singkatan' => 'DP3AP2KB'],
            ['unitkerja_id' => 23, 'sub_unitkerja' => 'UPTD PPA', 'singkatan' => 'UPTD PPA'],
            
            // Dinas PUPR (id:24)
            ['unitkerja_id' => 24, 'sub_unitkerja' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'singkatan' => 'DPUPR'],
            
            // Inspektorat (id:25)
            ['unitkerja_id' => 25, 'sub_unitkerja' => 'Inspektorat', 'singkatan' => 'INSPEKTORAT'],
            
            // Kecamatan Banjarsari (id:26)
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kecamatan Banjarsari', 'singkatan' => 'KEC. BANJARSARI'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Banjarsari', 'singkatan' => 'KEL. BANJARSARI'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Banyuanyar', 'singkatan' => 'KEL. BANYUANYAR'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Gilingan', 'singkatan' => 'KEL. GILINGAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Joglo', 'singkatan' => 'KEL. JOGLO'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Kadipiro', 'singkatan' => 'KEL. KADIPIRO'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Keprabon', 'singkatan' => 'KEL. KEPRABON'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Kestalan', 'singkatan' => 'KEL. KESTALAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Ketelan', 'singkatan' => 'KEL. KETELAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Manahan', 'singkatan' => 'KEL. MANAHAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Mangkubumen', 'singkatan' => 'KEL. MANGKUBUMEN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Nusukan', 'singkatan' => 'KEL. NUSUKAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Punggawan', 'singkatan' => 'KEL. PUNGGAWAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Setabelan', 'singkatan' => 'KEL. SETABELAN'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Sumber', 'singkatan' => 'KEL. SUMBER'],
            ['unitkerja_id' => 26, 'sub_unitkerja' => 'Kelurahan Timuran', 'singkatan' => 'KEL. TIMURAN'],
            
            // Kecamatan Jebres (id:27)
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kecamatan Jebres', 'singkatan' => 'KEC. JEBRES'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Gandekan', 'singkatan' => 'KEL. GANDEKAN'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Jagalan', 'singkatan' => 'KEL. JAGALAN'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Jebres', 'singkatan' => 'KEL. JEBRES'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Kepatihan Kulon', 'singkatan' => 'KEL. KEPATIHAN KULON'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Kepatihan Wetan', 'singkatan' => 'KEL. KEPATIHAN WETAN'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Mojosongo', 'singkatan' => 'KEL. MOJOSONGO'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Pucangsawit', 'singkatan' => 'KEL. PUCANGSAWIT'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Purwodiningratan', 'singkatan' => 'KEL. PURWODININGRATAN'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Sewu', 'singkatan' => 'KEL. SEWU'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Sudiroprajan', 'singkatan' => 'KEL. SUDIROPRAJAN'],
            ['unitkerja_id' => 27, 'sub_unitkerja' => 'Kelurahan Tegalharjo', 'singkatan' => 'KEL. TEGALHARJO'],
            
            // Kecamatan Laweyan (id:28)
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kecamatan Laweyan', 'singkatan' => 'KEC. LAWEYAN'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Bumi', 'singkatan' => 'KEL. BUMI'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Jajar', 'singkatan' => 'KEL. JAJAR'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Karangasem', 'singkatan' => 'KEL. KARANGASEM'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Kerten', 'singkatan' => 'KEL. KERTEN'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Laweyan', 'singkatan' => 'KEL. LAWEYAN'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Pajang', 'singkatan' => 'KEL. PAJANG'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Panularan', 'singkatan' => 'KEL. PANULARAN'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Penumping', 'singkatan' => 'KEL. PENUMPING'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Purwosari', 'singkatan' => 'KEL. PURWOSARI'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Sondakan', 'singkatan' => 'KEL. SONDAKAN'],
            ['unitkerja_id' => 28, 'sub_unitkerja' => 'Kelurahan Sriwedari', 'singkatan' => 'KEL. SRWEDARI'],
            
            // Kecamatan Pasarkliwon (id:29)
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kecamatan Pasarkliwon', 'singkatan' => 'KEC. PASARKLIWON'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Baluwarti', 'singkatan' => 'KEL. BALUWARTI'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Gajahan', 'singkatan' => 'KEL. GAJAHAN'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Joyosuran', 'singkatan' => 'KEL. JOYOSURAN'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Kampung Baru', 'singkatan' => 'KEL. KAMPUNG BARU'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Kauman', 'singkatan' => 'KEL. KAUMAN'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Kedung Lumbu', 'singkatan' => 'KEL. KEDUNG LUMBU'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Mojo', 'singkatan' => 'KEL. MOJO'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Pasarkliwon', 'singkatan' => 'KEL. PASARKLIWON'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Sangkrah', 'singkatan' => 'KEL. SANGKRAH'],
            ['unitkerja_id' => 29, 'sub_unitkerja' => 'Kelurahan Semanggi', 'singkatan' => 'KEL. SEMANGGI'],
            
            // Kecamatan Serengan (id:30)
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kecamatan Serengan', 'singkatan' => 'KEC. SERENGAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Danukusuman', 'singkatan' => 'KEL. DANUKUSUMAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Jayengan', 'singkatan' => 'KEL. JAYENGAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Joyotakan', 'singkatan' => 'KEL. JOYOTAKAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Kemlayan', 'singkatan' => 'KEL. KEMLAYAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Kratonan', 'singkatan' => 'KEL. KRATONAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Serengan', 'singkatan' => 'KEL. SERENGAN'],
            ['unitkerja_id' => 30, 'sub_unitkerja' => 'Kelurahan Tipes', 'singkatan' => 'KEL. TIPES'],
            
            // Badan Kesatuan Bangsa dan Politik (id:31)
            ['unitkerja_id' => 31, 'sub_unitkerja' => 'Badan Kesatuan Bangsa dan Politik', 'singkatan' => 'Bakesbangpol'],
            
            // RSUD Bung Karno (id:32)
            ['unitkerja_id' => 32, 'sub_unitkerja' => 'Rumah Sakit Umum Daerah Bung Karno', 'singkatan' => 'RSUD Bung Karno'],
            
            // RSUD Fatmawati Soekarno (id:33)
            ['unitkerja_id' => 33, 'sub_unitkerja' => 'Rumah Sakit Umum Daerah Ibu Fatmawati Soekarno', 'singkatan' => 'RSUD Fatmawati'],
            
            // Satpol PP (id:34)
            ['unitkerja_id' => 34, 'sub_unitkerja' => 'Satuan Polisi Pamong Praja', 'singkatan' => 'Satpol PP'],
            
            // Sekretariat Daerah (id:35)
            ['unitkerja_id' => 35, 'sub_unitkerja' => 'Sekretariat Daerah', 'singkatan' => 'Setda'],
            
            // Sekretariat DPRD (id:36)
            ['unitkerja_id' => 36, 'sub_unitkerja' => 'Sekretariat Dewan Perwakilan Rakyat Daerah', 'singkatan' => 'Setwan DPRD'],
        ];

        foreach ($subunits as $subunit) {
            ref_subunitkerjas::create([
                'unitkerja_id' => $subunit['unitkerja_id'],
                'sub_unitkerja' => $subunit['sub_unitkerja'],
                'singkatan' => $subunit['singkatan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}