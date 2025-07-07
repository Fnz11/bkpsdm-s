<?php

namespace App\Http\Controllers;

use App\Models\ref_jenispelatihans;
use App\Models\ref_namapelatihan;
use Illuminate\Http\Request;

class DeepwareNomenklaturController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();

        $namapelatihans = ref_namapelatihan::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelatihan', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('jenispelatihan', function ($q2) use ($search) {
                        $q2->where('jenis_pelatihan', 'like', "%{$search}%");
                    });
            });
        })
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($start && $end, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.nomenklatur.index', compact('namapelatihans', 'jenispelatihans'))->render();
        }

        return view('dashboard.pengaturandasar.nomenklatur.index', compact('namapelatihans', 'jenispelatihans'));
    }

    public function create()
    {
        return view('dashboard.pengaturandasar.nomenklatur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_namapelatihan' => 'required|string|max:255|unique:ref_namapelatihans,kode_namapelatihan',
            'nama_pelatihan' => 'required|string|max:255',
            'nip' => 'required|exists:users,nip',
            'status' => 'in:proses,',
        ]);

        ref_namapelatihan::create($request->all());

        return redirect()->route('dashboard.pengaturandasar.nomenklatur')->with('success', 'Usulan pelatihan berhasil dikirim.');
    }

    public function edit($id)
    {
        $namapelatihan = ref_namapelatihan::findOrFail($id);
        if (!$namapelatihan) {
            return redirect()->route('dashboard.pengaturandasar.nomenklatur')->with('error', 'Usulan pelatihan tidak ditemukan.');
        }
        return view('dashboard.pengaturandasar.nomenklatur.edit', compact('namapelatihan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_namapelatihan' => 'required|string|max:255|unique:ref_namapelatihans,kode_namapelatihan,' . $id,
            'status' => 'in:proses,diterima,ditolak',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $namapelatihan = ref_namapelatihan::findOrFail($id);
        $namapelatihan->update($request->all());

        return redirect()->route('dashboard.pengaturandasar.nomenklatur')->with('success', 'Usulan nama pelatihan berhasil diperbarui.');
    }

    //User
    public function index2()
    {
        $nip = auth()->user()->nip;
        $namapelatihans = ref_namapelatihan::where('nip', $nip)
            ->orderBy('created_at', 'desc') // urut dari terbaru
            ->get();

        return view('pelatihan.nomenklatur.index', compact('namapelatihans'));
    }

    public function create2()
    {
        return view('pelatihan.nomenklatur.create');
    }

    public function store2(Request $request)
    {
        $request->validate([
            // 'kode_namapelatihan' => 'required|string|max:255|unique:ref_namapelatihans,kode_namapelatihan',
            'nama_pelatihan' => 'required|string|max:255',
            'nip' => 'required|exists:users,nip',
            'status' => 'in:proses',
        ]);

        $data = $request->except('kode_namapelatihan');
        ref_namapelatihan::create($request->all());

        return redirect()->route('pelatihan.nomenklatur')->with('success', 'Usulan pelatihan berhasil dikirim.');
    }

    public function edit2($id)
    {
        return view('deepware.nomenklatur.edit', compact('id'));
    }
}
