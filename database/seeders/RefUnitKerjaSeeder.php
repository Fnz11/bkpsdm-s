<?php

namespace Database\Seeders;

use App\Models\ref_unitkerjas;
use Illuminate\Database\Seeder;

class RefUnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $unitkerjas = [
            ['kode_unitkerja' => 'BPPD', 'unitkerja' => 'Badan Perencanaan Pembangunan Daerah'],
            ['kode_unitkerja' => 'BKPSDM', 'unitkerja' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia'],
            ['kode_unitkerja' => 'BPBD', 'unitkerja' => 'Badan Penanggulangan Bencana Daerah'],
            ['kode_unitkerja' => 'BPKAD', 'unitkerja' => 'Badan Pengelolaan Keuangan dan Aset Daerah'],
            ['kode_unitkerja' => 'BRID', 'unitkerja' => 'Badan Riset dan Inovasi Daerah'],
            ['kode_unitkerja' => 'DPK', 'unitkerja' => 'Dinas Pemadam Kebakaran'],
            ['kode_unitkerja' => 'DKUKMP', 'unitkerja' => 'Dinas Koperasi Usaha Kecil dan Menengah dan Perindustrian'],
            ['kode_unitkerja' => 'DS', 'unitkerja' => 'Dinas Sosial'],
            ['kode_unitkerja' => 'DKP', 'unitkerja' => 'Dinas Kebudayaan dan Pariwisata'],
            ['kode_unitkerja' => 'DP', 'unitkerja' => 'Dinas Perdagangan'],
            ['kode_unitkerja' => 'DIKD', 'unitkerja' => 'Dinas Pendidikan'],
            ['kode_unitkerja' => 'DISHUB', 'unitkerja' => 'Dinas Perhubungan'],
            ['kode_unitkerja' => 'DKISP', 'unitkerja' => 'Dinas Komunikasi, Informatika, Statistik dan Persandian'],
            ['kode_unitkerja' => 'DISNAKER', 'unitkerja' => 'Dinas Tenaga Kerja'],
            ['kode_unitkerja' => 'DUKCAPIL', 'unitkerja' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['kode_unitkerja' => 'DPK', 'unitkerja' => 'Dinas Perpustakaan dan Kearsipan'],
            ['kode_unitkerja' => 'DPKPP', 'unitkerja' => 'Dinas Perumahan dan Kawasan Permukiman serta Pertanahan'],
            ['kode_unitkerja' => 'DISPORA', 'unitkerja' => 'Dinas Kepemudaan dan Olahraga'],
            ['kode_unitkerja' => 'DKES', 'unitkerja' => 'Dinas Kesehatan'],
            ['kode_unitkerja' => 'DKPP', 'unitkerja' => 'Dinas Ketahanan Pangan dan Pertanian'],
            ['kode_unitkerja' => 'DLH', 'unitkerja' => 'Dinas Lingkungan Hidup'],
            ['kode_unitkerja' => 'DPMPTSP', 'unitkerja' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu'],
            ['kode_unitkerja' => 'DP3AP2KB', 'unitkerja' => 'Dinas Pemberdayaan Perempuan dan Pelindungan Anak serta Pengendalian Penduduk dan Keluarga Berencana'],
            ['kode_unitkerja' => 'DPUPR', 'unitkerja' => 'Dinas Pekerjaan Umum dan Penataan Ruang'],
            ['kode_unitkerja' => 'INSP', 'unitkerja' => 'Inspektorat'],
            ['kode_unitkerja' => 'KECBS', 'unitkerja' => 'Kecamatan Banjarsari'],
            ['kode_unitkerja' => 'KECJS', 'unitkerja' => 'Kecamatan Jebres'],
            ['kode_unitkerja' => 'KECLW', 'unitkerja' => 'Kecamatan Laweyan'],
            ['kode_unitkerja' => 'KECPK', 'unitkerja' => 'Kecamatan Pasarkliwon'],
            ['kode_unitkerja' => 'KECSG', 'unitkerja' => 'Kecamatan Serengan'],
            ['kode_unitkerja' => 'BKB', 'unitkerja' => 'Badan Kesatuan Bangsa dan Politik'],
            ['kode_unitkerja' => 'RSUD', 'unitkerja' => 'Rumah Sakit Umum Daerah Bung Karno'],
            ['kode_unitkerja' => 'RSUD', 'unitkerja' => 'Rumah Sakit Umum Daerah Ibu Fatmawati Soekarno'],
            ['kode_unitkerja' => 'SATPOLPP', 'unitkerja' => 'Satuan Polisi Pamong Praja'],
            ['kode_unitkerja' => 'SETDA', 'unitkerja' => 'Sekretariat Daerah'],
            ['kode_unitkerja' => 'SETWAN', 'unitkerja' => 'Sekretariat Dewan Perwakilan Rakyat Daerah'],
        ];

        foreach ($unitkerjas as $unit) {
            $createdUnit = ref_unitkerjas::create([
                'kode_unitkerja' => $unit['kode_unitkerja'],
                'unitkerja' => $unit['unitkerja'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}