<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\ref_unitkerjas;
use App\Models\UserPivot;
use Illuminate\Http\Request;

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
            ->with(['unitKerja', 'jabatan', 'golongan', 'user.refPegawai'])
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->select('user_pivot.*')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ref_pegawai.name', 'like', "%$search%")
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('nama_jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('nama_golongan', 'like', "%$search%");
                        });
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('ref_pegawai.name')
            ->orderBy('user_pivot.created_at', 'desc');

        $activePivots = $queryActive->paginate($perPage)->withQueryString();

        // Query for proposed pivots
        $queryProposed = UserPivot::where('is_active', false)
            ->with(['unitKerja', 'jabatan', 'golongan', 'user.refPegawai'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('user.pegawai', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })
                        ->orWhere('user_pivot.nip', 'like', "%$search%")
                        ->orWhereHas('unitKerja', function ($q) use ($search) {
                            $q->where('unitkerja', 'like', "%$search%");
                        })
                        ->orWhereHas('jabatan', function ($q) use ($search) {
                            $q->where('nama_jabatan', 'like', "%$search%");
                        })
                        ->orWhereHas('golongan', function ($q) use ($search) {
                            $q->where('nama_golongan', 'like', "%$search%");
                        });
                });
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('user_pivot.tgl_mulai', [$start, $end]);
            })
            ->orderBy('user_pivot.created_at', 'desc');

        $proposedPivots = $queryProposed->paginate($perPage)->withQueryString();

        // Get all unit kerja for filter dropdown
        $unitkerjas = ref_unitkerjas::orderBy('unitkerja')->get();

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
            'unitkerjas' => $unitkerjas
        ]);
    }

    public function approve($id)
    {
        $pivot = UserPivot::findOrFail($id);
        $user = $pivot->user;
        // Temukan data aktif sebelumnya untuk user yang sama
        $previousActivePivot = $user->userPivot()
            ->where('is_active', true)
            ->where('id', '!=', $pivot->id) // Exclude pivot yang sedang di-approve
            ->orderBy('id', 'desc')
            ->first();

        if ($previousActivePivot) {
            $previousActivePivot->update([
                'tgl_akhir' => now()->format('Y-m-d')
            ]);
        }

        $pivot->update([
            'is_active' => true,
            'tgl_mulai' => now()->format('Y-m-d') // Optional: set tgl_mulai ke hari ini
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
}
