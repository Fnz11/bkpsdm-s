<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\RekapitulasiPendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\ref_unitkerjas;
use App\Models\UserPivot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RekapitulasiUsulanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        $view = $request->get('view');
        $perPage = 25;

        // --- Rekap Pelatihan ---
        $queryPelatihan = Pelatihan3Pendaftaran::selectRaw('
                COALESCE(tersedia.nama_pelatihan, usulan.nama_pelatihan) as nama_pelatihan,
                COUNT(*) as jumlah_usulan
            ')
            ->leftJoin('pelatihan_2_tersedias as tersedia', 'tersedia.id', '=', 'pelatihan_3_pendaftarans.tersedia_id')
            ->leftJoin('pelatihan_2_usulans as usulan', 'usulan.id', '=', 'pelatihan_3_pendaftarans.usulan_id')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('tersedia.nama_pelatihan', 'like', "%$search%")
                        ->orWhere('usulan.nama_pelatihan', 'like', "%$search%");
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$start, $end]);
            })
            ->groupBy('nama_pelatihan')
            ->orderBy('jumlah_usulan', 'desc');

        $rekapPelatihan = $queryPelatihan->paginate($perPage)->withQueryString();

        // --- Rekap OPD ---
        $queryOPD = ref_unitkerjas::select([
            'ref_unitkerjas.id as opd_id',
            'ref_unitkerjas.unitkerja as opd',
            DB::raw('COUNT(pelatihan_3_pendaftarans.id) as jumlah_usulan')
        ])
            ->leftJoin('ref_subunitkerjas', 'ref_subunitkerjas.unitkerja_id', '=', 'ref_unitkerjas.id')
            ->leftJoin('user_pivot', function ($join) {
                $join->on('user_pivot.id_unitkerja', '=', 'ref_subunitkerjas.id');
            })
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('pelatihan_3_pendaftarans', function ($join) use ($start, $end) {
                $join->on('pelatihan_3_pendaftarans.user_nip', '=', 'users.nip');

                if ($start && $end) {
                    $join->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$start, $end]);
                }
            })
            ->when($search, function ($q) use ($search) {
                $q->where('ref_unitkerjas.unitkerja', 'like', "%$search%");
            })
            ->groupBy('ref_unitkerjas.id', 'ref_unitkerjas.unitkerja')
            ->orderBy('ref_unitkerjas.unitkerja');

        $rekapOPD = $queryOPD->paginate($perPage)->withQueryString();

        // Get all OPDs for dropdown
        $unitkerjas = ref_unitkerjas::orderBy('unitkerja')->get();

        if ($request->ajax()) {
            if ($view === 'pelatihan') {
                return view('dashboard.pelatihan.rekapitulasipendaftaran._pelatihan', [
                    'rekapPelatihan' => $rekapPelatihan
                ])->render();
            } else {
                return view('dashboard.pelatihan.rekapitulasipendaftaran._opd', [
                    'rekapOPD' => $rekapOPD
                ])->render();
            }
        }

        return view('dashboard.pelatihan.rekapitulasipendaftaran.index', [
            'rekapPelatihan' => $rekapPelatihan,
            'rekapOPD' => $rekapOPD,
            'unitkerjas' => $unitkerjas
        ]);
    }

    /**
     * Method untuk preview data rekapitulasi
     */
    public function preview(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jenisRekap = $request->input('jenis_rekap', 'pelatihan');

        if ($jenisRekap === 'pelatihan') {
            $data = $this->getDataPelatihan($search, $startDate, $endDate);
        } else {
            $data = $this->getDataOPD($search, $startDate, $endDate);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Method untuk cetak PDF rekapitulasi
     */
    public function cetakPdf(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jenisRekap = $request->input('jenis_rekap', 'pelatihan');
        $paperSize = $request->input('paper_size', 'a4');
        $orientation = $request->input('orientation', 'portrait');

        if ($jenisRekap === 'pelatihan') {
            $data = $this->getDataPelatihan($search, $startDate, $endDate);
            $title = 'Rekapitulasi Pendaftaran Pelatihan';
        } else {
            $data = $this->getDataOPD($search, $startDate, $endDate);
            $title = 'Rekapitulasi Pendaftaran Per OPD';
        }

        $filterInfo = [
            'search' => $search ?: '-',
            'date_range' => ($startDate && $endDate) ? "$startDate s/d $endDate" : '-',
            'total_data' => count($data),
            'paper_size' => strtoupper($paperSize),
            'orientation' => $orientation === 'portrait' ? 'Portrait' : 'Landscape'
        ];

        $pdf = Pdf::loadView('dashboard.pelatihan.rekapitulasipendaftaran.pdf', [
            'title' => $title,
            'data' => $data,
            'filterInfo' => $filterInfo,
            'jenisRekap' => $jenisRekap
        ]);

        $pdf->setPaper($paperSize, $orientation);

        $filename = 'Rekapitulasi_Pendaftaran_' . ($jenisRekap === 'pelatihan' ? 'Pelatihan' : 'OPD') . '_' . date('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }

    public function cetakExcel(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jenisRekap = $request->input('jenis_rekap', 'pelatihan');
        $includeHeader = $request->has('include_header');
        $columns = $request->input('columns', ['no', 'nama', 'jumlah']);
        $fileFormat = $request->input('file_format', 'xlsx');

        $filename = 'Rekapitulasi_Pendaftaran_' . ($jenisRekap === 'pelatihan' ? 'Pelatihan' : 'OPD') . '_' . date('YmdHis') . '.' . $fileFormat;

        return Excel::download(
            new RekapitulasiPendaftaranExport(
                $search,
                $startDate,
                $endDate,
                $jenisRekap,
                $includeHeader,
                $columns,
                $fileFormat
            ),
            $filename
        );
    }

    /**
     * Query untuk data per pelatihan
     */
    private function getDataPelatihan($search = null, $startDate = null, $endDate = null)
    {
        $query = Pelatihan3Pendaftaran::selectRaw('
                COALESCE(tersedia.nama_pelatihan, usulan.nama_pelatihan) as nama,
                COUNT(*) as jumlah_usulan
            ')
            ->leftJoin('pelatihan_2_tersedias as tersedia', 'tersedia.id', '=', 'pelatihan_3_pendaftarans.tersedia_id')
            ->leftJoin('pelatihan_2_usulans as usulan', 'usulan.id', '=', 'pelatihan_3_pendaftarans.usulan_id')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('tersedia.nama_pelatihan', 'like', "%$search%")
                        ->orWhere('usulan.nama_pelatihan', 'like', "%$search%");
                });
            })
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$startDate, $endDate]);
            })
            ->groupBy('nama')
            ->orderBy('jumlah_usulan', 'desc');

        return $query->get();
    }

    /**
     * Query untuk data per OPD
     */
    private function getDataOPD($search = null, $startDate = null, $endDate = null)
    {
        $query = ref_unitkerjas::select([
            'ref_unitkerjas.id',
            'ref_unitkerjas.unitkerja as opd',
            DB::raw('COUNT(pelatihan_3_pendaftarans.id) as jumlah_usulan')
        ])
            ->leftJoin('ref_subunitkerjas', 'ref_subunitkerjas.unitkerja_id', '=', 'ref_unitkerjas.id')
            ->leftJoin('user_pivot', 'user_pivot.id_unitkerja', '=', 'ref_subunitkerjas.id')
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('pelatihan_3_pendaftarans', function ($join) use ($startDate, $endDate) {
                $join->on('pelatihan_3_pendaftarans.user_nip', '=', 'users.nip');

                if ($startDate && $endDate) {
                    $join->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$startDate, $endDate]);
                }
            })
            ->when($search, function ($q) use ($search) {
                $q->where('ref_unitkerjas.unitkerja', 'like', "%$search%");
            })
            ->groupBy('ref_unitkerjas.id', 'ref_unitkerjas.unitkerja')
            ->orderBy('ref_unitkerjas.unitkerja');

        return $query->get();
    }
}
