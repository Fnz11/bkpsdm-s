<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan3Dokumen;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\PelatihanTenggatUpload;
use App\Models\ref_unitkerjas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihanDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $user = Auth::user();
        if ($user->role === 'admin') {
            $unit = $user->latestUserPivot->unitKerja->unitkerja_id;
        } else {
            $unit = $request->get('unit_id');
        }

        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();

        $currentYear = date('Y');
        $deadline = PelatihanTenggatUpload::where('tahun', $currentYear)
            ->where('jenis_deadline', 'dokumen_admin')
            ->orderBy('id', 'desc')
            ->first();

        $dokumens = Pelatihan3Dokumen::with('admin.latestUserPivot.unitKerja')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_dokumen', 'like', '%' . $search . '%')
                        ->orWhere('keterangan', 'like', '%' . $search . '%');
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('admin.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit));
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_upload', [$start, $end]))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.dokumen.index', compact('dokumens', 'unitkerjas', 'deadline'))->render();
        }

        return view('dashboard.pelatihan.dokumen.index', compact('dokumens', 'unitkerjas', 'deadline'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitkerja = Auth::user()->latestUserPivot->unitKerja->unitkerja_id;
        $pendaftarans = Pelatihan3Pendaftaran::where('status_verifikasi', 'tercetak')
            ->whereNull('dokumen_id')
            ->whereHas('user.latestUserPivot.unitKerja', function ($query) use ($unitkerja) {
                $query->where('unitkerja_id', $unitkerja);
            })->get();

        return view('dashboard.pelatihan.dokumen.create', compact('pendaftarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf|max:2048',
            'pendaftaran_ids' => 'required|array',
            'pendaftaran_ids.*' => 'exists:pelatihan_3_pendaftarans,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file_path');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/dokumen', $filename, 'public');

        $dokumen = Pelatihan3Dokumen::create([
            'admin_nip' => Auth::user()->nip,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $path,
            'keterangan' => $request->keterangan,
        ]);

        // Update pendaftaran dengan dokumen_id yang baru dibuat
        Pelatihan3Pendaftaran::whereIn('id', $request->pendaftaran_ids)
            ->update([
                'dokumen_id' => $dokumen->id,
                'status_verifikasi' => 'terkirim'
            ]);

        return redirect()->route('dashboard.pelatihan.dokumen')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumen = Pelatihan3Dokumen::with(['pendaftarans.user', 'pendaftarans.tersedia', 'pendaftarans.usulan'])
            ->findOrFail($id);
        $pendaftarans = $dokumen->pendaftarans()->with(['tersedia', 'usulan'])->paginate(10);
        return view('dashboard.pelatihan.dokumen.detail', compact('dokumen', 'pendaftarans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dokumen = Pelatihan3Dokumen::findOrFail($id);
        $pendaftarans = $dokumen->pendaftarans()->with(['tersedia', 'usulan'])->paginate(10);
        return view('dashboard.pelatihan.dokumen.edit', compact('dokumen', 'pendaftarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'nullable|string|max:255',
            'status' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $dokumen = Pelatihan3Dokumen::findOrFail($id);

        $dokumen->update([
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.pelatihan.dokumen')->with('success', 'Dokumen berhasil diperbarui.');
    }
}
