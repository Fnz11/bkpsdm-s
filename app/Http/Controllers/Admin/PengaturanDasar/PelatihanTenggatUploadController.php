<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\PelatihanTenggatUpload;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan3Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelatihanTenggatUploadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $modalFields = $this->getModalFields();

        $tenggats = PelatihanTenggatUpload::with(['pelatihanTersedia', 'pendaftaran'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('keterangan', 'like', "%{$search}%")
                        ->orWhere('jenis_deadline', 'like', "%{$search}%")
                        ->orWhere('tahun', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tahun')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.tenggatupload.index', compact('tenggats'))->render();
        }

        return view('dashboard.pengaturandasar.tenggatupload.index', compact('tenggats'));
    }

    public function create()
    {
        return view('dashboard.pengaturandasar.tenggatupload.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun'             => 'required|integer|min:2000|max:' . date('Y'),
            'jenis_deadline'    => 'required|in:laporan_user,dokumen_admin',
            'tanggal_deadline'  => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_mulai'     => 'nullable|date|before_or_equal:tanggal_deadline',
            'tersedia_id'       => 'nullable|exists:pelatihan_2_tersedias,id',
            'pendaftaran_id'    => 'nullable|exists:pelatihan_3_pendaftarans,id',
            'keterangan'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'open_modal'    => true,
                    'modal_action'  => 'create',
                    'modal_fields'  => $this->getModalFields(),
                ]);
        }

        PelatihanTenggatUpload::create($request->all());

        return redirect()->back()->with([
            'message' => 'Tenggat upload berhasil ditambahkan.',
            'title' => 'Success',
        ]);
    }

    public function edit($id)
    {
        $tenggat = PelatihanTenggatUpload::findOrFail($id);

        return view('dashboard.pengaturandasar.tenggatupload.edit', compact('tenggat'));
    }

    public function update(Request $request, $id)
    {
        $tenggat = PelatihanTenggatUpload::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun'             => 'required|integer|min:2000|max:' . date('Y'),
            'jenis_deadline'    => 'required|in:laporan_user,dokumen_admin',
            'tanggal_deadline'  => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_mulai'     => 'nullable|date|before_or_equal:tanggal_deadline',
            'tersedia_id'       => 'nullable|exists:pelatihan_2_tersedias,id',
            'pendaftaran_id'    => 'nullable|exists:pelatihan_3_pendaftarans,id',
            'keterangan'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'open_modal'    => true,
                    'modal_action'  => 'edit',
                    'modal_fields'  => $this->getModalFields(),
                    'data_edit'     => ['id' => $id],
                ]);
        }

        $tenggat->update($request->all());

        return redirect()->back()->with([
            'message' => 'Tenggat upload berhasil diperbarui.',
            'title' => 'Success',
        ]);
    }

    public function destroy($id)
    {
        $tenggat = PelatihanTenggatUpload::findOrFail($id);
        $tenggat->delete();

        return redirect()->back()->with([
            'message' => 'Tenggat upload berhasil dihapus.',
            'title' => 'Success',
        ]);
    }

    public function getModalFields()
    {
        $tersediaOptions = Pelatihan2Tersedia::select('id', 'nama_pelatihan')->orderBy('nama_pelatihan')->get()
            ->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->nama_pelatihan,
            ])
            ->prepend(['value' => '', 'label' => 'Pilih Pelatihan Tersedia', 'disabled' => true])->values();

        $pendaftaranOptions = Pelatihan3Pendaftaran::select('id')->orderBy('id')->get()
            ->map(fn($item) => [
                'value' => $item->id,
                'label' => 'Pendaftaran #' . $item->id,
            ])
            ->prepend(['value' => '', 'label' => 'Pilih Pendaftaran', 'disabled' => true])->values();

        return [
            [
                'name' => 'tahun',
                'type' => 'number',
                'label' => 'Tahun',
                'required' => true,
                'placeholder' => 'Contoh: 2025',
                'col' => 6,
            ],
            [
                'name' => 'jenis_deadline',
                'type' => 'select',
                'label' => 'Jenis Deadline',
                'required' => true,
                'options' => [
                    ['value' => 'laporan_user', 'label' => 'Laporan User'],
                    ['value' => 'dokumen_admin', 'label' => 'Dokumen Admin'],
                ],
                'col' => 6,
            ],
            [
                'name' => 'tanggal_mulai',
                'type' => 'date',
                'label' => 'Tanggal Mulai',
                'col' => 6,
            ],
            [
                'name' => 'tanggal_deadline',
                'type' => 'date',
                'label' => 'Tanggal Deadline',
                'required' => true,
                'col' => 6,
            ],
            [
                'name' => 'tersedia_id',
                'type' => 'select',
                'label' => 'Pelatihan Tersedia',
                'options' => $tersediaOptions,
                'col' => 6,
            ],
            [
                'name' => 'pendaftaran_id',
                'type' => 'select',
                'label' => 'Pendaftaran (Usulan)',
                'options' => $pendaftaranOptions,
                'col' => 6,
            ],
            [
                'name' => 'keterangan',
                'type' => 'textarea',
                'label' => 'Keterangan',
                'placeholder' => 'Tambahkan catatan jika diperlukan',
            ],
        ];
    }
}
