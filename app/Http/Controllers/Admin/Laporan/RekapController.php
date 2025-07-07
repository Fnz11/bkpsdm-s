<?php
namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Brosur_2_masuk;
use App\Models\Directory_2_laporan;
use App\Models\Katalog_2_masuks;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'brosur'); // Default: 'brosur'

        // === 📌 Rekap Data Brosur ===
        $rekapBrosur = Brosur_2_masuk::selectRaw('YEAR(created_at) as tahun,
                SUM(CASE WHEN status = "diterima" THEN 1 ELSE 0 END) as jumlah_diterima,
                SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as jumlah_ditolak,
                SUM(CASE WHEN status = "proses" THEN 1 ELSE 0 END) as jumlah_diproses')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        // **Indikator Total Brosur**
        $jumlahDiterima = Brosur_2_masuk::where('status', 'diterima')->count();
        $jumlahDitolak = Brosur_2_masuk::where('status', 'ditolak')->count();
        $jumlahDiproses = Brosur_2_masuk::where('status', 'proses')->count();
        $totalDataBrosur = Brosur_2_masuk::count();

        // === 📌 Rekap Data Direktori ===
        $rekapDirektori = Directory_2_laporan::selectRaw('YEAR(created_at) as tahun, 
                nama_pelatihan,
                SUM(CASE WHEN hasil_pelatihan = "lulus" THEN 1 ELSE 0 END) as jumlah_lulus,
                SUM(CASE WHEN hasil_pelatihan = "tidak lulus" THEN 1 ELSE 0 END) as jumlah_tidak_lulus')
            ->groupBy('tahun', 'nama_pelatihan')
            ->orderBy('tahun', 'desc')
            ->get();

        // **Indikator Total Direktori**
        $totalLulus = Directory_2_laporan::where('hasil_pelatihan', 'lulus')->count();
        $totalTidakLulus = Directory_2_laporan::where('hasil_pelatihan', 'tidak lulus')->count();
        $totalDataDirektori = Directory_2_laporan::count();

        // === 📌 Rekap Data Katalog ===
        $rekapKatalog = Katalog_2_masuks::selectRaw('YEAR(created_at) as tahun, 
        jenis_pelatihan,
        SUM(CASE WHEN status = "visible" THEN 1 ELSE 0 END) as jumlah_show,
        SUM(CASE WHEN status = "hide" THEN 1 ELSE 0 END) as jumlah_hide')
            ->groupBy('tahun', 'jenis_pelatihan')
            ->orderBy('tahun', 'desc')
            ->get();
            
        // **Indikator Total Katalog**
        $totalShow = Katalog_2_masuks::where('status', 'visible')->count();
        $totalHide = Katalog_2_masuks::where('status', 'show')->count();
        $totalDataKatalog = Katalog_2_masuks::count();

        
        return view('Admin.laporan.rekap', compact(
            'filter',
            'rekapBrosur', 'jumlahDiterima', 'jumlahDitolak', 'jumlahDiproses', 'totalDataBrosur',
            'rekapDirektori', 'totalLulus', 'totalTidakLulus', 'totalDataDirektori',
            'rekapKatalog',  'totalShow', 'totalHide', 'totalDataKatalog'
        ));
    }
}
