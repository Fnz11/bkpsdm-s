<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_subunitkerjas;
use App\Models\ref_unitkerjas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefSubUnitKerjaController extends Controller
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

        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();

        $subunitkerjas = ref_subunitkerjas::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('sub_unitkerja', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhereHas('unitkerja', function ($q2) use ($search) {
                        $q2->where('unitkerja', 'like', "%{$search}%");
                    });
            });
        })
            ->orderBy('sub_unitkerja')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.subunitkerja.index', compact('subunitkerjas', 'unitkerjas'))->render();
        }

        return view('dashboard.pengaturandasar.subunitkerja.index', compact('subunitkerjas', 'unitkerjas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.subunitkerja.create');
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
            'unikerja_id' => 'required|exists:ref_unitkerjas,id',
            'sub_unitkerja' => 'required|string|max:255',
            'singkatan' => 'required|string|max:50',
        ], [
            'unikerja_id.required' => 'Unit Kerja wajib dipilih.',
            'unikerja_id.exists' => 'Unit Kerja tidak valid.',
            'sub_unitkerja.required' => 'Sub Unit Kerja wajib diisi.',
            'sub_unitkerja.max' => 'Sub Unit Kerja tidak boleh lebih dari 255 karakter.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'singkatan.max' => 'Singkatan tidak boleh lebih dari 50 karakter.',
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

        ref_subunitkerjas::create($request->all());

        return redirect()->back()->with([
            'message' => 'Sub Unit Kerja berhasil ditambahkan.',
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
        $subunitkerja = ref_subunitkerjas::findOrFail($id);
        return view('dashboard.pengaturandasar.subunitkerja.edit', compact('subunitkerja'));
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
            'unikerja_id' => 'required|exists:ref_unitkerjas,id',
            'sub_unitkerja' => 'required|string|max:255',
            'singkatan' => 'required|string|max:50',
        ], [
            'unikerja_id.required' => 'Unit Kerja wajib dipilih.',
            'unikerja_id.exists' => 'Unit Kerja tidak valid.',
            'sub_unitkerja.required' => 'Sub Unit Kerja wajib diisi.',
            'sub_unitkerja.max' => 'Sub Unit Kerja tidak boleh lebih dari 255 karakter.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'singkatan.max' => 'Singkatan tidak boleh lebih dari 50 karakter.',
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

        $subunitkerja = ref_subunitkerjas::findOrFail($id);
        $subunitkerja->update($request->all());

        return redirect()->back()->with([
            'message' => 'Sub Unit Kerja berhasil diperbarui.',
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
        $subunitkerja = ref_subunitkerjas::findOrFail($id);
        if (!$subunitkerja) {
            return redirect()->back()->with([
                'message' => 'Sub Unit Kerja tidak ditemukan.',
                'title' => 'Error',
            ]);
        }
        $subunitkerja->delete();

        return redirect()->back()->with([
            'message' => 'Sub Unit Kerja berhasil dihapus.',
            'title' => 'Success',
        ]);
    }

    /**
     * Get modal fields for dynamic modal.
     *
     * @return array
     */
    protected function getModalFields()
    {
        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get()
            ->map(function ($unitkerja) {
                return [
                    'value' => $unitkerja->id,
                    'label' => $unitkerja->unitkerja,
                ];
            })
            ->prepend([
                'value' => '',
                'label' => 'Pilih Unit Kerja',
                'disabled' => true,
            ])
            ->values();

        return [
            [
                'name' => 'unitkerja_id',
                'label' => 'Unit Kerja',
                'type' => 'select',
                'options' => $unitkerjas,
                'required' => true,
                'col' => 12,
            ],
            [
                'name' => 'sub_unitkerja',
                'label' => 'Sub Unit Kerja',
                'type' => 'text',
                'required' => true,
                'col' => 6,
            ],
            [
                'name' => 'singkatan',
                'label' => 'Singkatan',
                'type' => 'text',
                'required' => true,
                'col' => 6,
            ],
        ];
    }
}
