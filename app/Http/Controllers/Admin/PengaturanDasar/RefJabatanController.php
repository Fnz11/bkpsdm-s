<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_jabatans;
use App\Models\ref_kategorijabatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefJabatanController extends Controller
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

        $kategorijabatans = ref_kategorijabatans::select('id', 'kategori_jabatan')
            ->orderBy('kategori_jabatan')
            ->get();

        $jabatans = ref_jabatans::with('kategorijabatan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jabatan', 'like', "%{$search}%")
                        ->orWhereHas('kategorijabatan', function ($q2) use ($search) {
                            $q2->where('kategori_jabatan', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('jabatan')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.jabatan.index', compact('jabatans', 'kategorijabatans'))->render();
        }

        return view('dashboard.pengaturandasar.jabatan.index', compact('jabatans', 'kategorijabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.jabatan.create');
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
            'kategorijabatan_id' => 'required|string|max:255|exists:ref_kategorijabatans,id',
            'jabatan' => 'required|string|max:255',
        ], [
            'kategorijabatan_id.required' => 'Kategori Jabatan wajib diisi.',
            'kategorijabatan_id.exists'   => 'Kategori Jabatan tidak valid.',
            'jabatan.required'            => 'Jabatan wajib diisi.',
            'jabatan.max'                 => 'Jabatan tidak boleh lebih dari 255 karakter.',
        ]);

        // Validasi awal gagal
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

        // Cek duplikasi kombinasi kategori & jabatan
        $exists = ref_jabatans::where('kategorijabatan_id', $request->kategorijabatan_id)
            ->where('jabatan', $request->jabatan)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['jabatan' => 'Jabatan dengan kategori tersebut sudah terdaftar.'])
                ->withInput()
                ->with([
                    'open_modal'    => true,
                    'modal_action'  => 'create',
                    'modal_fields'  => $this->getModalFields(),
                ]);
        }

        // Simpan jika valid dan unik
        ref_jabatans::create($request->all());

        return redirect()->route('dashboard.pelatihan.jabatan')
            ->with([
                'message' => 'Jabatan berhasil ditambahkan.',
                'title'   => 'Success',
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
        $jabatan = ref_jabatans::findOrFail($id);
        if (!$jabatan) {
            return redirect()->route('dashboard.pelatihan.jabatan')
                ->with([
                    'message' => 'Jabatan tidak ditemukan.',
                    'title' => 'Error',
                ]);
        }
        return view('dashboard.pengaturandasar.jabatan.edit', compact('jabatan'));
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
        $jabatan = ref_jabatans::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kategorijabatan_id' => 'required|string|max:255|exists:ref_kategorijabatans,id',
            'jabatan' => 'required|string|max:255',
        ], [
            'kategorijabatan_id.required' => 'Kategori Jabatan wajib diisi.',
            'kategorijabatan_id.exists'   => 'Kategori Jabatan tidak valid.',
            'jabatan.required'            => 'Jabatan wajib diisi.',
            'jabatan.max'                 => 'Jabatan tidak boleh lebih dari 255 karakter.',
        ]);

        // Validasi awal gagal
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

        // Cek duplikasi kombinasi kategori & jabatan
        $exists = ref_jabatans::where('kategorijabatan_id', $request->kategorijabatan_id)
            ->where('jabatan', $request->jabatan)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['jabatan' => 'Jabatan dengan kategori tersebut sudah terdaftar.'])
                ->withInput()
                ->with([
                    'open_modal'    => true,
                    'modal_action'  => 'edit',
                    'modal_fields'  => $this->getModalFields(),
                    'data_edit' => ['id' => $id],
                ]);
        }

        $jabatan->update($request->all());

        return redirect()->route('dashboard.pelatihan.jabatan')
            ->with([
                'message' => 'Jabatan berhasil diperbarui.',
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
        $jabatan = ref_jabatans::findOrFail($id);
        if (!$jabatan) {
            return redirect()->route('dashboard.pelatihan.jabatan')
                ->with([
                    'message' => 'Jabatan tidak ditemukan.',
                    'title' => 'Error',
                ]);
        }

        $jabatan->delete();

        return redirect()->route('dashboard.pelatihan.jabatan')
            ->with([
                'message' => 'Jabatan berhasil dihapus.',
                'title' => 'Success',
            ]);
    }

    /**
     * Get modal field definitions for dynamic modal.
     *
     * @return array
     */
    public function getModalFields()
    {
        $kategoriOptions = ref_kategorijabatans::orderBy('kategori_jabatan')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->kategori_jabatan,
                ];
            })
            ->prepend([
                'value' => '',
                'label' => '-- Pilih Kategori Jabatan --',
                'disabled' => true,
            ])
            ->values(); // reset key numerik agar rapi di JS

        return [
            [
                'name' => 'kategorijabatan_id',
                'type' => 'select',
                'label' => 'Kategori Jabatan',
                'options' => $kategoriOptions,
                'required' => true,
                'col' => 12,
            ],
            [
                'name' => 'jabatan',
                'type' => 'text',
                'label' => 'Jabatan',
                'required' => true,
                'placeholder' => 'Contoh: Kepala Dinas, Sekretaris, dll.',
                'col' => 12,
            ],
        ];
    }
}
