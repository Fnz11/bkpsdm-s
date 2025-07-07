<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_kategorijabatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefKategoriJabatanController extends Controller
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

        $kategorijabatans = ref_kategorijabatans::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('kategori_jabatan', 'like', "%{$search}%")
                    ->orWhere('kode_kategorijabatan', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_kategorijabatan')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.kategorijabatan.index', compact('kategorijabatans'))->render();
        }

        return view('dashboard.pengaturandasar.kategorijabatan.index', compact('kategorijabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.kategorijabatan.create');
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
            'kode_kategorijabatan' => 'required|string|max:255|unique:ref_kategorijabatans,kode_kategorijabatan',
            'kategori_jabatan' => 'required|string|max:255',
        ], [
            'kode_kategorijabatan.required' => 'Kode Kategori Jabatan wajib diisi.',
            'kode_kategorijabatan.unique' => 'Kode Kategori Jabatan sudah digunakan.',
            'kode_kategorijabatan.max' => 'Kode Kategori Jabatan tidak boleh lebih dari 255 karakter.',
            'kategori_jabatan.required' => 'Kategori Jabatan wajib diisi.',
            'kategori_jabatan.max' => 'Kategori Jabatan tidak boleh lebih dari 255 karakter.',
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

        ref_kategorijabatans::create($request->all());

        return redirect()->back()->with([
            'message' => 'Kategori Jabatan berhasil ditambahkan.',
            'title' => 'Success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $kategorijabatan = ref_kategorijabatans::findOrFail($id);
        if (!$kategorijabatan) {
            return redirect()->back()->with([
                'message' => 'Kategori Jabatan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }
        return view('dashboard.pengaturandasar.kategorijabatan.edit', compact('kategorijabatan'));
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
            'kode_kategorijabatan' => 'required|string|max:255|unique:ref_kategorijabatans,kode_kategorijabatan,' . $id,
            'kategori_jabatan' => 'required|string|max:255',
        ], [
            'kode_kategorijabatan.required' => 'Kode Kategori Jabatan wajib diisi.',
            'kode_kategorijabatan.unique' => 'Kode Kategori Jabatan sudah digunakan.',
            'kode_kategorijabatan.max' => 'Kode Kategori Jabatan tidak boleh lebih dari 255 karakter.',
            'kategori_jabatan.required' => 'Kategori Jabatan wajib diisi.',
            'kategori_jabatan.max' => 'Kategori Jabatan tidak boleh lebih dari 255 karakter.',
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

        $kategorijabatan = ref_kategorijabatans::findOrFail($id);
        $kategorijabatan->update($request->all());

        return redirect()->back()->with([
            'message' => 'Kategori Jabatan berhasil diperbarui.',
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
        $kategorijabatan = ref_kategorijabatans::findOrFail($id);
        if (!$kategorijabatan) {
            return redirect()->back()->with([
                'message' => 'Kategori Jabatan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        $kategorijabatan->delete();

        return redirect()->back()->with([
            'message' => 'Kategori Jabatan berhasil dihapus.',
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
        return [
            [
                'name' => 'kode_kategorijabatan',
                'label' => 'Kode Kategori Jabatan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: KJ001',
            ],
            [
                'name' => 'kategori_jabatan',
                'label' => 'Kategori Jabatan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: Jabatan Pimpinan Tinggi',
            ],
        ];
    }
}
