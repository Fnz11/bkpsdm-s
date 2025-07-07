<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_golongans;
use App\Models\ref_jenisasns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefGolonganController extends Controller
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

        $golongans = ref_golongans::with('jenisasn')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('golongan', 'like', "%{$search}%")
                        ->orWhere('pangkat', 'like', "%{$search}%")
                        ->orWhere('pangkat_golongan', 'like', "%{$search}%")
                        ->orWhereHas('jenisasn', function ($q2) use ($search) {
                            $q2->where('jenis_asn', 'like', "%{$search}%");
                        })
                        ->orWhere('kode_golongan', 'like', "%{$search}%");
                });
            })
            ->orderBy('kode_golongan')
            ->paginate(25)
            ->withQueryString();

        $jenisasns = ref_jenisasns::select('id', 'jenis_asn')->orderBy('jenis_asn')->get();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.golongan.index', compact('golongans', 'jenisasns'))->render();
        }

        return view('dashboard.pengaturandasar.golongan.index', compact('golongans', 'jenisasns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.golongan.create');
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
            'kode_golongan' => 'required|string|max:255|unique:ref_golongans,kode_golongan',
            'jenisasn_id' => 'required|exists:ref_jenisasns,id',
            'golongan' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
        ], [
            'kode_golongan.required' => 'Kode Golongan wajib diisi.',
            'kode_golongan.unique' => 'Kode Golongan sudah digunakan.',
            'jenisasn_id.required' => 'Jenis ASN wajib dipilih.',
            'jenisasn_id.exists' => 'Jenis ASN tidak valid.',
            'golongan.required' => 'Golongan wajib diisi.',
            'golongan.max' => 'Golongan tidak boleh lebih dari 255 karakter.',
            'pangkat.required' => 'Pangkat wajib diisi.',
            'pangkat.max' => 'Pangkat tidak boleh lebih dari 255 karakter.',
            'pangkat_golongan.required' => 'Pangkat Golongan wajib diisi.',
            'pangkat_golongan.max' => 'Pangkat Golongan tidak boleh lebih dari 255 karakter.',
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

        ref_golongans::create($request->all());

        return redirect()->back()->with([
            'message' => 'Golongan berhasil ditambahkan.',
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
        $golongan = ref_golongans::findOrFail($id);
        if (!$golongan) {
            return redirect()->back()->with([
                'message' => 'Golongan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        return view('dashboard.pengaturandasar.golongan.edit', compact('golongan'));
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
        $golongan = ref_golongans::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_golongan' => 'required|string|max:255|unique:ref_golongans,kode_golongan,' . $id,
            'jenisasn_id' => 'required|exists:ref_jenisasns,id',
            'golongan' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
        ], [
            'kode_golongan.required' => 'Kode Golongan wajib diisi.',
            'kode_golongan.unique' => 'Kode Golongan sudah digunakan.',
            'jenisasn_id.required' => 'Jenis ASN wajib dipilih.',
            'jenisasn_id.exists' => 'Jenis ASN tidak valid.',
            'golongan.required' => 'Golongan wajib diisi.',
            'golongan.max' => 'Golongan tidak boleh lebih dari 255 karakter.',
            'pangkat.required' => 'Pangkat wajib diisi.',
            'pangkat.max' => 'Pangkat tidak boleh lebih dari 255 karakter.',
            'pangkat_golongan.required' => 'Pangkat Golongan wajib diisi.',
            'pangkat_golongan.max' => 'Pangkat Golongan tidak boleh lebih dari 255 karakter.',
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

        $golongan->update($request->all());

        return redirect()->back()->with([
            'message' => 'Golongan berhasil diperbarui.',
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
        $golongan = ref_golongans::findOrFail($id);
        if (!$golongan) {
            return redirect()->back()->with([
                'message' => 'Golongan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        $golongan->delete();

        return redirect()->back()->with([
            'message' => 'Golongan berhasil dihapus.',
            'title' => 'Success',
        ]);
    }

    public function getModalFields()
    {
        $jenisasnoptions = ref_jenisasns::select('id', 'jenis_asn')
            ->orderBy('jenis_asn')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->jenis_asn,
                ];
            })
            ->prepend([
                'value' => '',
                'label' => 'Pilih Jenis ASN',
                'disabled' => true,
            ])
            ->values();

        return [
            [
                'name' => 'kode_golongan',
                'type' => 'text',
                'label' => 'Kode Golongan',
                'required' => true,
                'placeholder' => 'Contoh: III/a, IV/c',
                'col' => 6,
            ],
            [
                'name' => 'jenisasn_id',
                'type' => 'select',
                'label' => 'Jenis ASN',
                'required' => true,
                'options' => $jenisasnoptions,
                'col' => 6,
            ],
            [
                'name' => 'golongan',
                'type' => 'text',
                'label' => 'Golongan',
                'required' => true,
                'placeholder' => 'Contoh: Penata Muda',
                'col' => 6,
            ],
            [
                'name' => 'pangkat',
                'type' => 'text',
                'label' => 'Pangkat',
                'required' => true,
                'placeholder' => 'Contoh: Pembina Utama',
                'col' => 6,
            ],
            [
                'name' => 'pangkat_golongan',
                'type' => 'text',
                'label' => 'Pangkat & Golongan',
                'required' => true,
                'placeholder' => 'Contoh: Pembina / IVa',
            ],
        ];
    }
}
