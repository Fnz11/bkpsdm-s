<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_brosur
 * @property string $link_brosur
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereInfoBrosur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereLinkBrosur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_1_info whereUpdatedAt($value)
 */
	class Brosur_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_penyelenggara
 * @property string $alamat
 * @property string $nama_sales
 * @property string $no_hp
 * @property string $no_surat
 * @property string $tanggal_surat
 * @property string|null $brosur_excel
 * @property string|null $brosur_pdf
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereBrosurExcel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereBrosurPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereNamaPenyelenggara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereNamaSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereTanggalSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brosur_2_masuk whereUpdatedAt($value)
 */
	class Brosur_2_masuk extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard query()
 */
	class Dashboard extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_katalog
 * @property string $link_info
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereInfoKatalog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereLinkInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_1_info whereUpdatedAt($value)
 */
	class Directory_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $golongan_ruang
 * @property string $jabatan
 * @property string $unit_kerja
 * @property string $email
 * @property string $foto
 * @property string $nama_pelatihan
 * @property string $pelaksanaan_pelatihan
 * @property string $jenis_pelatihan
 * @property string $metode_pelatihan
 * @property string $rumpun_pelatihan
 * @property string $penyelenggara_pelatihan
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $hasil_pelatihan
 * @property string $sertifikat
 * @property string $judul_laporan
 * @property string $abstrak_laporan
 * @property string $link_laporan
 * @property string $Status_peserta
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereAbstrakLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereGolonganRuang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereHasilPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereJenisPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereJudulLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereLinkLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereMetodePelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan wherePelaksanaanPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan wherePenyelenggaraPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereRumpunPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereStatusPeserta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory_2_laporan whereUpdatedAt($value)
 */
	class Directory_2_laporan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_ipasn
 * @property string $link_info
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereInfoIpasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereLinkInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_1_info whereUpdatedAt($value)
 */
	class Ipasn_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $tanggal_penetapan
 * @property int $nilai
 * @property string $link_bkn
 * @property string $link_bkpsdm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereLinkBkn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereLinkBkpsdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereTanggalPenetapan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_2_historyinstansi whereUpdatedAt($value)
 */
	class Ipasn_2_historyinstansi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property int $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $unit_kerja
 * @property int $nilai_pendidikan
 * @property int $nilai_kinerja
 * @property int $nilai_disiplin
 * @property int $nilai_bangkom
 * @property int $nilai_totalipasn
 * @property int $link_filepenetapanbkd
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereLinkFilepenetapanbkd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNilaiBangkom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNilaiDisiplin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNilaiKinerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNilaiPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNilaiTotalipasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ipasn_3_nilaiperasn whereUpdatedAt($value)
 */
	class Ipasn_3_nilaiperasn extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $alumni_id
 * @property int $pertanyaan_index
 * @property string $jawaban
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban whereAlumniId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban whereJawaban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban wherePertanyaanIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban whereUpdatedAt($value)
 */
	class Jawaban extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_katalog
 * @property string $link_info
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereInfoKatalog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereLinkInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_1_info whereUpdatedAt($value)
 */
	class Katalog_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_pelatihan
 * @property string $nama_penyelenggara
 * @property string $nama_CP
 * @property string $no_HP
 * @property string $jenis_pelatihan
 * @property string $metode_pelatihan
 * @property string $pelaksanaan_pelatihan
 * @property string $rumpun_pelatihan
 * @property string $informasi_pelatihan
 * @property string $file_pelatihan
 * @property string $estimasi_biaya
 * @property string $status
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereEstimasiBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereFilePelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereInformasiPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereJenisPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereMetodePelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereNamaCP($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereNamaPenyelenggara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereNoHP($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks wherePelaksanaanPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereRumpunPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Katalog_2_masuks whereUpdatedAt($value)
 */
	class Katalog_2_masuks extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property string $linkdrive
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereLinkdrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Linkdrive whereUpdatedAt($value)
 */
	class Linkdrive extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_pelatihan
 * @property string $link_pelatihan
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereInfoPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereLinkPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_1_info whereUpdatedAt($value)
 */
	class Pelatihan_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $pangkat_golongan
 * @property string $jabatan
 * @property string $unitkerja
 * @property string $no_hp
 * @property string $nama_pelatihan
 * @property string $pelaksanaan_pelatihan
 * @property string $metode_pelatihan
 * @property string $jenis_pelatihan
 * @property string $penyelenggara_pelatihan
 * @property string $tempat_pelatihan
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $estimasi_biaya
 * @property string $file_penawaran
 * @property string $file_usulan
 * @property string $keterangan
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereEstimasiBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereFilePenawaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereFileUsulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereJenisPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereMetodePelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan wherePelaksanaanPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan wherePenyelenggaraPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereTempatPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereUnitkerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelatihan_2_usulan whereUpdatedAt($value)
 */
	class Pelatihan_2_usulan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_jenispelatihan
 * @property string $kode_kategoripertanyaan
 * @property string $pertanyaan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan whereKodeJenispelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan whereKodeKategoripertanyaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan wherePertanyaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pertanyaan whereUpdatedAt($value)
 */
	class Pertanyaan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_solowasis
 * @property string $gambar_solowasis
 * @property string $link_solowasis
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereGambarSolowasis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereInfoSolowasis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereLinkSolowasis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_1_info whereUpdatedAt($value)
 */
	class Solowasis_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property string $nama_pelatihan
 * @property string $jumlah_jp
 * @property string $jumlah_peserta
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereJumlahJp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereJumlahPeserta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solowasis_2_daftarlatsolowasis whereUpdatedAt($value)
 */
	class Solowasis_2_daftarlatsolowasis extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $nip
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $is_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|admin whereUpdatedAt($value)
 */
	class admin extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kategori_jabatan
 * @property int $jml_integritas
 * @property int $jml_kerjasama
 * @property int $jml_komunikasi
 * @property int $jml_orientasipada_hasil
 * @property int $jml_pelayanan_publik
 * @property int $jml_pengembangan_diri
 * @property int $jml_mengelola_perubahan
 * @property int $jml_pengambilan_keputusan
 * @property int $jml_penguasaan_teknologi
 * @property int $jml_keahlian_spesifik
 * @property int $jml_penerapan_prosedur
 * @property int $jml_kemajemukan
 * @property int $jml_menghargai
 * @property int $jml_tolerasi
 * @property int $jml_daya_guna
 * @property int $jml_hubungan_sosial
 * @property string $komentar_integritas
 * @property string $komentar_kerjasama
 * @property string $komentar_komunikasi
 * @property string $komentar_orientasi_pada_hasil
 * @property string $komentar_pelayanan_publik
 * @property string $komentar_pengembangan_diri
 * @property string $komentar_mengelola_perubahan
 * @property string $komentar_pengambilan_keputusan
 * @property string $komentar_penguasaan_teknologi
 * @property string $komentar_keahlian_spesifik
 * @property string $komentar_penerapan_prosedur
 * @property string $komentar_kemajemukan
 * @property string $komentar_menghargai
 * @property string $komentar_tolerasi
 * @property string $komentar_daya_guna
 * @property string $komentar_hubungan_sosial
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlIntegritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlOrientasipadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereJmlTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKategoriJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarIntegritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarOrientasiPadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereKomentarTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_10_komentar whereUpdatedAt($value)
 */
	class akpk_10_komentar extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $tahun
 * @property int $nip
 * @property int $nip_atasan
 * @property string $kategori_jabatan
 * @property int $standarmin_integritas
 * @property int $standarmin_kerjasama
 * @property int $standarmin_komunikasi
 * @property int $standarmin_orientasi_pada_hasil
 * @property int $standarmin_pelayanan_publik
 * @property int $standarmin_pengembangan_diri
 * @property int $standarmin_mengelola_perubahan
 * @property int $standarmin_pengambilan_keputusan
 * @property int $standarmin_penguasaan_teknologi
 * @property int $standarmin_keahlian_spesifik
 * @property int $standarmin_penerapan_prosedur
 * @property int $standarmin_kemajemukan
 * @property int $standarmin_menghargai
 * @property int $standarmin_tolerasi
 * @property int $standarmin_daya_guna
 * @property int $standarmin_hubungan_sosial
 * @property string $self_kompetensi_ditingkatkan
 * @property string $self_pelatihan_dibutuhkan
 * @property int $atasan_integritas
 * @property int $atasan_kerjasama
 * @property int $atasan_komunikasi
 * @property int $atasan_orientasi_pada_hasil
 * @property int $atasan_pelayanan_publik
 * @property int $atasan_pengembangan_diri
 * @property int $atasan_mengelola_perubahan
 * @property int $atasan_pengambilan_keputusan
 * @property int $atasan_penguasaan_teknologi
 * @property int $atasan_keahlian_spesifik
 * @property int $atasan_penerapan_prosedur
 * @property int $atasan_kemajemukan
 * @property int $atasan_menghargai
 * @property int $atasan_tolerasi
 * @property int $atasan_daya_guna
 * @property int $atasan_hubungan_sosial
 * @property string $atasan_kompetensi_dikembangkan
 * @property string $atasan_rekomendari_pelatihan
 * @property string $atasan_alasan_rekomendasi
 * @property int $jml_integritas
 * @property int $jml_kerjasama
 * @property int $jml_komunikasi
 * @property int $jml_orientasi_pada_hasil
 * @property int $jml_pelayanan_publik
 * @property int $jml_pengembangan_diri
 * @property int $jml_mengelola_perubahan
 * @property int $jml_pengambilan_keputusan
 * @property int $jml_penguasaan_teknologi
 * @property int $jml_keahlian_spesifik
 * @property int $jml_penerapan_prosedur
 * @property int $jml_kemajemukan
 * @property int $jml_menghargai
 * @property int $jml_tolerasi
 * @property int $jml_daya_guna
 * @property int $jml_hubungan_sosial
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanAlasanRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanIntegritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanKompetensiDikembangkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanOrientasiPadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanRekomendariPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereAtasanTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlIntegritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlOrientasiPadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereJmlTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereKategoriJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereNipAtasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereSelfKompetensiDitingkatkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereSelfPelatihanDibutuhkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminIntegritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminOrientasiPadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereStandarminTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_11_hasilakhir whereUpdatedAt($value)
 */
	class akpk_11_hasilakhir extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $info_akpk
 * @property string $link_info
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereInfoAkpk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereLinkInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_1_info whereUpdatedAt($value)
 */
	class akpk_1_info extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_2_selfassesment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_2_selfassesment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_2_selfassesment query()
 */
	class akpk_2_selfassesment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_3_penilaianbawahan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_3_penilaianbawahan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_3_penilaianbawahan query()
 */
	class akpk_3_penilaianbawahan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_4_usulansolowasis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_4_usulansolowasis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_4_usulansolowasis query()
 */
	class akpk_4_usulansolowasis extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $tahun
 * @property int $nip
 * @property string $nama
 * @property string $pangkat_golongan
 * @property string $jabatan
 * @property string $unitkerja
 * @property string $nama_usulanpelatihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereNamaUsulanpelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereUnitkerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_5_usulpelatihanumum whereUpdatedAt($value)
 */
	class akpk_5_usulpelatihanumum extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $tahun
 * @property int $jenis_usulan
 * @property string $nama_usulan
 * @property string $keterangan
 * @property string $file_pdf
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereFilePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereJenisUsulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereNamaUsulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_6_kirimusulanopd whereUpdatedAt($value)
 */
	class akpk_6_kirimusulanopd extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_7_penanggungjawab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_7_penanggungjawab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_7_penanggungjawab query()
 */
	class akpk_7_penanggungjawab extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property string $kode_tampil
 * @property string $nama_pelatihan ]
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereKodeTampil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereNamaPelatihan]($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_8_settingusulsolowasis whereUpdatedAt($value)
 */
	class akpk_8_settingusulsolowasis extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kategori_jabatan
 * @property int $standarmin_integeregritas
 * @property int $standarmin_kerjasama
 * @property int $standarmin_komunikasi
 * @property int $standarmin_orientasipada_hasil
 * @property int $standarmin_pelayanan_publik
 * @property int $standarmin_pengembangan_diri
 * @property int $standarmin_mengelola_perubahan
 * @property int $standarmin_pengambilan_keputusan
 * @property int $standarmin_penguasaan_teknologi
 * @property int $standarmin_keahlian_spesifik
 * @property int $standarmin_penerapan_prosedur
 * @property int $standarmin_kemajemukan
 * @property int $standarmin_menghargai
 * @property int $standarmin_tolerasi
 * @property int $standarmin_daya_guna
 * @property int $standarmin_hubungan_sosial
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereKategoriJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminDayaGuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminHubunganSosial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminIntegeregritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminKeahlianSpesifik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminKemajemukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminKerjasama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminKomunikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminMengelolaPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminMenghargai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminOrientasipadaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminPelayananPublik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminPenerapanProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminPengambilanKeputusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminPengembanganDiri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminPenguasaanTeknologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereStandarminTolerasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|akpk_9_standarmin whereUpdatedAt($value)
 */
	class akpk_9_standarmin extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $alumni_id
 * @property int $nip
 * @property string $nama
 * @property string $pangkat
 * @property string $golongan
 * @property string $jabatan
 * @property string $unit_kerja
 * @property string $nama_pelatihan
 * @property string $kode_jenispelatihan
 * @property int $nip_atasan
 * @property string $nama_atasan
 * @property int $nip_rekankerja
 * @property string $nama_rekankerja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereAlumniId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereKodeJenispelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNamaAtasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNamaRekankerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNipAtasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereNipRekankerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_1_alumni whereUpdatedAt($value)
 */
	class eva_1_alumni extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $pangkat_golongan
 * @property string $jabatan
 * @property string $unit_kerja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_2_atasan whereUpdatedAt($value)
 */
	class eva_2_atasan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_3_rekansejawat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_3_rekansejawat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|eva_3_rekansejawat query()
 */
	class eva_3_rekansejawat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $pangkat_golongan
 * @property string $jabatan
 * @property string $unitkerja
 * @property string $nama_pelatihan
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $hasil_pelatihan
 * @property string $sertifikat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereHasilPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereUnitkerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_1_pelatihan whereUpdatedAt($value)
 */
	class pbj_1_pelatihan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $pangkat_golongan
 * @property string $jabatan
 * @property string $unitkerja
 * @property string $nama_pelatihan
 * @property string $nama_sertifikasi
 * @property string $tanggal_sertifikasi
 * @property string $hasil_sertifikasi
 * @property string $sertifikat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereHasilSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereNamaSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereTanggalSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereUnitkerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pbj_2_sertifikasi whereUpdatedAt($value)
 */
	class pbj_2_sertifikasi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_golongan
 * @property string $jenis_asn
 * @property string $golongan
 * @property string $pangkat
 * @property string $pangkat_golongan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereJenisAsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereKodeGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_golongans whereUpdatedAt($value)
 */
	class ref_golongans extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_jenisasn
 * @property string $jenis_asn
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn whereJenisAsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn whereKodeJenisasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenisasn whereUpdatedAt($value)
 */
	class ref_jenisasn extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_jenispelatihan
 * @property string $jenis_pelatihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans whereJenisPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans whereKodeJenispelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_jenispelatihans whereUpdatedAt($value)
 */
	class ref_jenispelatihans extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_kategorijabatan
 * @property string $kategori_jabatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans whereKategoriJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans whereKodeKategorijabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_kategorijabatans whereUpdatedAt($value)
 */
	class ref_kategorijabatans extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_metodepelatihan
 * @property string $metode_pelatihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans whereKodeMetodepelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans whereMetodePelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_metodepelatihans whereUpdatedAt($value)
 */
	class ref_metodepelatihans extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_jabatanasn
 * @property string $jabatanasn
 * @property string $kategori_jabatanasn
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereJabatanasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereKategoriJabatanasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereKodeJabatanasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namajabatanasns whereUpdatedAt($value)
 */
	class ref_namajabatanasns extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jenis_pelatihan
 * @property string $nama_pelatihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan whereJenisPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapelatihan whereUpdatedAt($value)
 */
	class ref_namapelatihan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_namapenyelenggara whereUpdatedAt($value)
 */
	class ref_namapenyelenggara extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $pangkat
 * @property string $golongan
 * @property string $jabatan
 * @property string $jenis_asn
 * @property string $kategori_jabatanasn
 * @property string $unit_kerja
 * @property string $email
 * @property string $no_hp
 * @property string $alamat
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereJenisAsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereKategoriJabatanasn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pegawais whereUpdatedAt($value)
 */
	class ref_pegawais extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_pelaksanaanpelatihan
 * @property string $pelaksanaan_pelatihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans whereKodePelaksanaanpelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans wherePelaksanaanPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_pelaksanaanpelatihans whereUpdatedAt($value)
 */
	class ref_pelaksanaanpelatihans extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ref_unitkerjas whereUpdatedAt($value)
 */
	class ref_unitkerjas extends \Eloquent {}
}

