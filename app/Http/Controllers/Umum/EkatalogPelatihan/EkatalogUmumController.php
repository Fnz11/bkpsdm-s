<?php

namespace App\Http\Controllers\Umum\EkatalogPelatihan;

use App\Models\Katalog_2_masuks;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EkatalogUmumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Pencarian nama pelatihan
        $tahun = $request->input('tahun'); // Filter berdasarkan tahun

        // Ambil daftar tahun dari data pelatihan
        $years = Katalog_2_masuks::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Query hanya untuk data dengan status "visible"
        $diklats = Katalog_2_masuks::where('status', 'visible')
            ->when($search, function ($query, $search) {
                return $query->where('nama_pelatihan', 'like', "%$search%");
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Log hasil pencarian
        if ($diklats->isNotEmpty()) {
            Log::info('Data retrieved for ekatalog', ['data_count' => $diklats->count()]);
        } else {
            Log::info('No data found for ekatalog', ['search' => $search, 'tahun' => $tahun]);
        }

        return view('MenuUmum.EkatalogPelatihan.ekatalog', compact('diklats', 'search', 'years', 'tahun'));
    }

    public function view($id)
    {
        // Cari data berdasarkan ID
        $usulan_laporan_diklat = Katalog_2_masuks::find($id);

        // Jika data tidak ditemukan, redirect ke halaman daftar dengan pesan error
        if (!$usulan_laporan_diklat) {
            return redirect()->route('admin.ekatalog.index')->with('error', 'Data tidak ditemukan');
        }

        // Kirim data ke tampilan yang benar
        return view('MenuUmum.EkatalogPelatihan.viewekatalog', compact('usulan_laporan_diklat'));
    }
}
