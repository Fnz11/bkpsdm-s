<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\UserPivotExport;
use App\Http\Controllers\Controller;
use App\Models\ref_unitkerjas;
use App\Models\ref_jenis_asn;
use App\Models\ref_jenisasns;
use App\Models\UserPivot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserPivotController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        $view = $request->get('view');
        $perPage = 25;

        // Query for active pivots
        $queryActive = UserPivot::where('is_active', true)
            ->with(['unitKerja.unitkerja', 'jabatan.kategorijabatan', 'golongan.jenisasn', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja.unitkerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('golongan', 'like', "%$search%")
                                ->orWhere('pangkat', 'like', "%$search%");
                        });
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.tgl_mulai', 'desc');

        $activePivots = $queryActive->paginate($perPage)->withQueryString();

        // Query for proposed pivots
        $queryProposed = UserPivot::where('is_active', false)
            ->with(['unitKerja.unitkerja', 'jabatan.kategorijabatan', 'golongan.jenisasn', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja.unitkerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('golongan', 'like', "%$search%")
                                ->orWhere('pangkat', 'like', "%$search%");
                        });
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.created_at', 'desc');

        $proposedPivots = $queryProposed->paginate($perPage)->withQueryString();

        // Get all unit kerja and jenis ASN for filter dropdown
        $unitkerjas = ref_unitkerjas::orderBy('unitkerja')->get();
        $jenisASNs = ref_jenisasns::orderBy('jenis_asn')->get();

        if ($request->ajax()) {
            if ($view === 'usulan') {
                return view('dashboard.pelatihan.userpivot._usulan', [
                    'proposedPivots' => $proposedPivots
                ])->render();
            } else {
                return view('dashboard.pelatihan.userpivot._active', [
                    'activePivots' => $activePivots
                ])->render();
            }
        }

        return view('dashboard.pelatihan.userpivot.index', [
            'activePivots' => $activePivots,
            'proposedPivots' => $proposedPivots,
            'unitkerjas' => $unitkerjas,
            'jenisasns' => $jenisASNs
        ]);
    }

    public function approve($id)
    {
        $pivot = UserPivot::findOrFail($id);
        $user = $pivot->user;

        // Temukan data aktif sebelumnya untuk user yang sama
        $previousActivePivot = $user->userPivot()
            ->where('is_active', true)
            ->where('id', '!=', $pivot->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($previousActivePivot) {
            $previousActivePivot->update([
                'tgl_akhir' => now()->format('Y-m-d')
            ]);
        }

        $pivot->update([
            'is_active' => true,
            'tgl_mulai' => now()->format('Y-m-d')
        ]);

        return back()->with([
            'message' => 'Usulan perubahan berhasil disetujui.',
            'title' => 'Success',
        ]);
    }

    public function reject($id)
    {
        $pivot = UserPivot::findOrFail($id);
        $pivot->delete();

        return back()->with([
            'message' => 'Usulan perubahan berhasil ditolak.',
            'title' => 'Success',
        ]);
    }

    public function cetakPdf(Request $request)
    {
        $search = $request->input('search');
        $unitKerja = $request->input('unit_kerja');
        $jenisAsn = $request->input('jenis_asn');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = UserPivot::with(['unitKerja.unitkerja', 'jabatan.kategorijabatan', 'golongan.jenisasn', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->where('is_active', true)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja.unitkerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('golongan', 'like', "%$search%")
                                ->orWhere('pangkat', 'like', "%$search%");
                        });
                });
            })
            ->when($unitKerja, function ($q) use ($unitKerja) {
                $q->whereHas('unitKerja', function ($q) use ($unitKerja) {
                    $q->where('id_unitkerja', $unitKerja);
                });
            })
            ->when($jenisAsn, function ($q) use ($jenisAsn) {
                $q->whereHas('golongan.jenisasn', function ($q) use ($jenisAsn) {
                    $q->where('id', $jenisAsn);
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.tgl_mulai', 'desc');

        $pivots = $query->get();

        $pdfSettings = [
            'paper_size' => $request->input('paper_size', 'a4'),
            'orientation' => $request->input('orientation', 'portrait'),
            'margin_top' => $request->input('margin_top', 0.5),
            'margin_right' => $request->input('margin_right', 0.5),
            'margin_bottom' => $request->input('margin_bottom', 0.5),
            'margin_left' => $request->input('margin_left', 0.5),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer')
        ];

        $pdf = Pdf::loadView('dashboard.pelatihan.userpivot.pdf', compact('pivots', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], $pdfSettings['orientation']);
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('data_history_pegawai_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $search = $request->input('search');
        $unitKerja = $request->input('unit_kerja');
        $jenisAsn = $request->input('jenis_asn');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $columns = $request->input('columns', []);
        $fileFormat = $request->input('file_format', 'xlsx');
        $includeHeader = $request->has('include_header');

        $query = UserPivot::with(['unitKerja.unitkerja', 'jabatan.kategorijabatan', 'golongan.jenisasn', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->where('is_active', true)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja.unitkerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('golongan', 'like', "%$search%")
                                ->orWhere('pangkat', 'like', "%$search%");
                        });
                });
            })
            ->when($unitKerja, function ($q) use ($unitKerja) {
                $q->whereHas('unitKerja', function ($q) use ($unitKerja) {
                    $q->where('id_unitkerja', $unitKerja);
                });
            })
            ->when($jenisAsn, function ($q) use ($jenisAsn) {
                $q->whereHas('golongan.jenisasn', function ($q) use ($jenisAsn) {
                    $q->where('id', $jenisAsn);
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.tgl_mulai', 'desc');

        $pivots = $query->get();

        return Excel::download(
            new UserPivotExport($pivots, $columns, $includeHeader),
            'data_history_pegawai_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
            $fileFormat === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX
        );
    }

    public function preview(Request $request)
    {
        $search = $request->input('search');
        $unitKerja = $request->input('unit_kerja');
        $jenisAsn = $request->input('jenis_asn');
        $start = $request->input('start');
        $end = $request->input('end');

        $query = UserPivot::with(['unitKerja.unitkerja', 'jabatan.kategorijabatan', 'golongan.jenisasn', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->where('is_active', true)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja.unitkerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('golongan', 'like', "%$search%")
                                ->orWhere('pangkat', 'like', "%$search%");
                        });
                });
            })
            ->when($unitKerja, function ($q) use ($unitKerja) {
                $q->whereHas('unitKerja', function ($q) use ($unitKerja) {
                    $q->where('id_unitkerja', $unitKerja);
                });
            })
            ->when($jenisAsn, function ($q) use ($jenisAsn) {
                $q->whereHas('golongan.jenisasn', function ($q) use ($jenisAsn) {
                    $q->where('id', $jenisAsn);
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.tgl_mulai', 'desc');

        $data = $query->get();

        return response()->json(['data' => $data]);
    }
}
