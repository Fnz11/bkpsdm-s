<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_unitkerjas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefUnitKerjaController extends Controller
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

        $unitkerjas = ref_unitkerjas::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('unitkerja', 'like', "%{$search}%")
                    ->orWhere('kode_unitkerja', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_unitkerja')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.unitkerja._table', compact('unitkerjas'))->render();
        }

        return view('dashboard.pengaturandasar.unitkerja.index', compact('unitkerjas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.unitkerja.create');
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
            'kode_unitkerja' => 'required|string|max:255|unique:ref_unitkerjas,kode_unitkerja',
            'unitkerja' => 'required|string|max:255',
        ], [
            'kode_unitkerja.required' => 'Kode Unit Kerja wajib diisi.',
            'kode_unitkerja.unique' => 'Kode Unit Kerja sudah digunakan.',
            'kode_unitkerja.max' => 'Kode Unit Kerja tidak boleh lebih dari 255 karakter.',
            'unitkerja.required' => 'Nama Unit Kerja wajib diisi.',
            'unitkerja.max' => 'Nama Unit Kerja tidak boleh lebih dari 255 karakter.',
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

        ref_unitkerjas::create($request->all());

        return redirect()->back()->with([
            'message' => 'Unit Kerja berhasil ditambahkan.',
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
        $unitkerja = ref_unitkerjas::findOrFail($id);
        if (!$unitkerja) {
            return redirect()->back()->with([
                'message' => 'Unit Kerja tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        return view('dashboard.pengaturandasar.unitkerja.edit', compact('unitkerja'));
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
        $unitkerja = ref_unitkerjas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_unitkerja' => 'required|string|max:255|unique:ref_unitkerjas,kode_unitkerja,' . $id,
            'unitkerja' => 'required|string|max:255',
        ], [
            'kode_unitkerja.required' => 'Kode Unit Kerja wajib diisi.',
            'kode_unitkerja.unique' => 'Kode Unit Kerja sudah digunakan.',
            'kode_unitkerja.max' => 'Kode Unit Kerja tidak boleh lebih dari 255 karakter.',
            'unitkerja.required' => 'Nama Unit Kerja wajib diisi.',
            'unitkerja.max' => 'Nama Unit Kerja tidak boleh lebih dari 255 karakter.',
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

        $unitkerja->update($request->all());

        return redirect()->back()
            ->with([
                'message' => 'Unit Kerja berhasil diperbarui.',
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
        $unitkerja = ref_unitkerjas::findOrFail($id);
        if (!$unitkerja) {
            return redirect()->back()->with([
                'message' => 'Unit Kerja tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        $unitkerja->delete();

        return redirect()->back()->with([
            'message' => 'Unit Kerja berhasil dihapus.',
            'title' => 'Success',
        ]);
    }

    /**
     * Get modal fields for create/edit modal.
     *
     * @return array
     */
    public function getModalFields()
    {
        return [
            [
                'name' => 'kode_unitkerja',
                'type' => 'text',
                'label' => 'Kode Unit Kerja',
                'required' => true,
                'placeholder' => 'Contoh: 123.A',
            ],
            [
                'name' => 'unitkerja',
                'type' => 'text',
                'label' => 'Unit Kerja',
                'required' => true,
                'placeholder' => 'Contoh: Bagian Umum',
            ],
        ];
    }
}
