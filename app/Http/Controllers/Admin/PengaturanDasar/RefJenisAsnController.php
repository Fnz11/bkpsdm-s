<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_jenisasns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefJenisAsnController extends Controller
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

        $jenisasns = ref_jenisasns::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('jenis_asn', 'like', "%{$search}%")
                    ->orWhere('kode_jenisasn', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_jenisasn')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.jenisasn.index', compact('jenisasns'))->render();
        }

        return view('dashboard.pengaturandasar.jenisasn.index', compact('jenisasns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.jenisasn.create');
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
            'kode_jenisasn' => 'required|string|max:255|unique:ref_jenisasns,kode_jenisasn',
            'jenis_asn'     => 'required|string|max:255',
        ], [
            'kode_jenisasn.required' => 'Kode Jenis ASN wajib diisi.',
            'kode_jenisasn.unique'   => 'Kode Jenis ASN sudah digunakan.',
            'kode_jenisasn.max'      => 'Kode Jenis ASN tidak boleh lebih dari 255 karakter.',
            'jenis_asn.required'     => 'Jenis ASN wajib diisi.',
            'jenis_asn.max'          => 'Jenis ASN tidak boleh lebih dari 255 karakter.',
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

        ref_jenisasns::create($request->all());

        return redirect()->back()->with([
            'message' => 'Data berhasil ditambahkan.',
            'title' => 'Success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $jenisasn = ref_jenisasns::findOrFail($id);

        return view('dashboard.pengaturandasar.jenisasn.edit', compact('jenisasn'));
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
        $jenisasn = ref_jenisasns::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_jenisasn' => 'required|string|max:255|unique:ref_jenisasns,kode_jenisasn,' . ($id),
            'jenis_asn'     => 'required|string|max:255',
        ], [
            'kode_jenisasn.required' => 'Kode Jenis ASN wajib diisi.',
            'kode_jenisasn.unique'   => 'Kode Jenis ASN sudah digunakan.',
            'kode_jenisasn.max'      => 'Kode Jenis ASN tidak boleh lebih dari 255 karakter.',
            'jenis_asn.required'     => 'Jenis ASN wajib diisi.',
            'jenis_asn.max'          => 'Jenis ASN tidak boleh lebih dari 255 karakter.',
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

        $jenisasn->update($request->all());

        return redirect()->back()->with([
            'message' => 'Data berhasil diperbarui.',
            'title' => 'Success'
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
        $jenisasn = ref_jenisasns::findOrFail($id);
        if (!$jenisasn) {
            return redirect()->back()->with([
                'message' => 'Jenis ASN tidak ditemukan.',
                'title' => 'Error'
            ]);
        }

        $jenisasn->delete();

        return redirect()->back()->with([
            'message' => 'Jenis ASN berhasil dihapus.',
            'title' => 'Success'
        ]);
    }

    /**
     * Get the fields for the modal form.
     *
     * @return array
     */
    protected function getModalFields()
    {
        return [
            ['name' => 'kode_jenisasn', 'label' => 'Kode Jenis ASN', 'type' => 'text', 'required' => true],
            ['name' => 'jenis_asn', 'label' => 'Jenis ASN', 'type' => 'text', 'required' => true],
        ];
    }
}
