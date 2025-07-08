<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ref_jenispelatihans;
use App\Models\ref_namapelatihans;
use Auth;

class RefNomenklaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();

        $namapelatihans = ref_namapelatihans::with('jenispelatihan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%")
                        ->orWhere('kode_namapelatihan', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhereHas('jenispelatihan', function ($q2) use ($search) {
                            $q2->where('jenis_pelatihan', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user.refPegawai', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%{$search}%");
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

    public function indexAdmin(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();

        $namapelatihans = ref_namapelatihans::with('jenispelatihan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%")
                        ->orWhere('kode_namapelatihan', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhereHas('jenispelatihan', function ($q2) use ($search) {
                            $q2->where('jenis_pelatihan', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user.refPegawai', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($start && $end, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->where('nip', Auth::user()->nip)
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.nomenklaturadmin.index', compact('namapelatihans', 'jenispelatihans'))->render();
        }

        return view('dashboard.pelatihan.nomenklaturadmin.index', compact('namapelatihans', 'jenispelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')
            ->orderBy('jenis_pelatihan')
            ->get();

        return view('dashboard.pelatihan.nomenklaturadmin.create', compact('jenispelatihans'));
    }

    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_namapelatihan' => 'nullable|string|max:255|unique:ref_namapelatihans,kode_namapelatihan',
            'nama_pelatihan' => 'required|string|max:255',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'in:proses,diterima,ditolak',
        ], [
            'kode_namapelatihan.unique' => 'Kode nama pelatihan sudah digunakan',
            'kode_namapelatihan.max' => 'Kode nama pelatihan tidak boleh lebih dari 255 karakter',
            'nama_pelatihan.required' => 'Nama pelatihan harus diisi',
            'nama_pelatihan.max' => 'Nama pelatihan tidak boleh lebih dari 255 karakter',
            'jenispelatihan_id.required' => 'Jenis pelatihan harus dipilih',
            'jenispelatihan_id.exists' => 'Jenis pelatihan yang dipilih tidak valid',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',
            'status.in' => 'Status harus salah satu dari: proses, diterima, ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'open_modal' => true,
                    'modal_action' => 'create',
                    'modal_fields' => $this->getModalFields(),
                ]);
        }

        ref_namapelatihans::create([
            'kode_namapelatihan' => $request->kode_namapelatihan,
            'nama_pelatihan' => $request->nama_pelatihan,
            'jenispelatihan_id' => $request->jenispelatihan_id,
            'keterangan' => $request->keterangan,
            'status' => $request->status ?? 'diterima',
            'nip' => Auth::user()->nip,
        ]);

        return redirect()->route('dashboard.pelatihan.nomenklaturadmin')->with([
            'message' => 'Nama pelatihan berhasil ditambahkan',
            'title' => 'Success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_namapelatihan' => 'nullable|string|max:255|unique:ref_namapelatihans,kode_namapelatihan',
            'nama_pelatihan' => 'required|string|max:255',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'in:proses,diterima,ditolak',
        ], [
            'kode_namapelatihan.unique' => 'Kode nama pelatihan sudah digunakan',
            'kode_namapelatihan.max' => 'Kode nama pelatihan tidak boleh lebih dari 255 karakter',
            'nama_pelatihan.required' => 'Nama pelatihan harus diisi',
            'nama_pelatihan.max' => 'Nama pelatihan tidak boleh lebih dari 255 karakter',
            'jenispelatihan_id.required' => 'Jenis pelatihan harus dipilih',
            'jenispelatihan_id.exists' => 'Jenis pelatihan yang dipilih tidak valid',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',
            'status.in' => 'Status harus salah satu dari: proses, diterima, ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'open_modal' => true,
                    'modal_action' => 'create',
                    'modal_fields' => $this->getModalFields(),
                ]);
        }

        ref_namapelatihans::create([
            'kode_namapelatihan' => $request->kode_namapelatihan,
            'nama_pelatihan' => $request->nama_pelatihan,
            'jenispelatihan_id' => $request->jenispelatihan_id,
            'keterangan' => $request->keterangan,
            'status' => $request->status ?? 'diterima',
            'nip' => Auth::user()->nip,
        ]);

        return redirect()->back()->with([
            'message' => 'Nama pelatihan berhasil ditambahkan',
            'title' => 'Success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $namapelatihan = ref_namapelatihans::findOrFail($id);
        return view('dashboard.pengaturandasar.nomenklatur.edit', compact('namapelatihan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_namapelatihan' => 'required|string|max:255|unique:ref_namapelatihans,kode_namapelatihan,' . $id,
            'nama_pelatihan' => 'required|string|max:255',
            'status' => 'in:proses,diterima,ditolak',
            'keterangan' => 'nullable|string|max:255',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
        ], [
            'kode_namapelatihan.required' => 'Kode nama pelatihan harus diisi',
            'kode_namapelatihan.unique' => 'Kode nama pelatihan sudah digunakan',
            'kode_namapelatihan.max' => 'Kode nama pelatihan tidak boleh lebih dari 255 karakter',
            'nama_pelatihan.required' => 'Nama pelatihan harus diisi',
            'nama_pelatihan.max' => 'Nama pelatihan tidak boleh lebih dari 255 karakter',
            'jenispelatihan_id.required' => 'Jenis pelatihan harus dipilih',
            'jenispelatihan_id.exists' => 'Jenis pelatihan yang dipilih tidak valid',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',
            'status.in' => 'Status harus salah satu dari: proses, diterima, ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'open_modal' => true,
                    'modal_action' => 'edit',
                    'modal_fields' => $this->getModalFields(),
                    'data_edit' => ['id' => $id],
                ]);
        }

        $namapelatihan = ref_namapelatihans::findOrFail($id);
        $namapelatihan->update($request->all());

        return redirect()->back()->with([
            'message' => 'Nama pelatihan berhasil diperbarui',
            'title' => 'Success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $namapelatihan = ref_namapelatihans::findOrFail($id);
        if (!$namapelatihan) {
            return redirect()->back()->with([
                'message' => 'Nama pelatihan tidak ditemukan',
                'title' => 'Error',
            ]);
        }
        $namapelatihan->delete();

        return redirect()->back()->with([
            'message' => 'Nama pelatihan berhasil dihapus',
            'title' => 'Success',
        ]);
    }

    /**
     * Get modal fields for dynamic modal.
     *
     * @return array
     */
    public function getModalFields()
    {
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')
            ->orderBy('jenis_pelatihan')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->jenis_pelatihan,
                ];
            })
            ->prepend([
                'value' => '',
                'label' => 'Pilih Jenis Pelatihan',
                'disabled' => true,
            ])
            ->values();

        return [
            [
                'name' => 'kode_namapelatihan',
                'label' => 'Kode Pelatihan',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'nama_pelatihan',
                'label' => 'Nama Pelatihan',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'jenispelatihan_id',
                'label' => 'Jenis Pelatihan',
                'type' => 'select',
                'required' => true,
                'col' => 6,
                'options' => $jenispelatihans,
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'required' => true,
                'col' => 6,
                'options' => [
                    ['value' => '', 'label' => 'Pilih Status', 'disabled' => true],
                    ['value' => 'proses', 'label' => 'Proses'],
                    ['value' => 'diterima', 'label' => 'Diterima'],
                    ['value' => 'ditolak', 'label' => 'Ditolak'],
                ],
            ],
            [
                'name' => 'keterangan',
                'label' => 'Keterangan',
                'type' => 'textarea',
                'required' => false,
                'col' => 12,
            ],
        ];
    }
}
