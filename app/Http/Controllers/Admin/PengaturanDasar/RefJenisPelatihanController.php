<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_jenispelatihans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefJenisPelatihanController extends Controller
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

        $jenispelatihans = ref_jenispelatihans::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pelatihan', 'like', "%{$search}%")
                    ->orWhere('kode_jenispelatihan', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_jenispelatihan')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.jenispelatihan.index', compact('jenispelatihans'))->render();
        }

        return view('dashboard.pengaturandasar.jenispelatihan.index', compact('jenispelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.jenispelatihan.create');
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
            'kode_jenispelatihan' => 'required|string|max:255|unique:ref_jenispelatihans,kode_jenispelatihan',
            'jenis_pelatihan' => 'required|string|max:255',
        ], [
            'kode_jenispelatihan.required' => 'Kode Jenis Pelatihan wajib diisi.',
            'kode_jenispelatihan.unique' => 'Kode Jenis Pelatihan sudah digunakan.',
            'kode_jenispelatihan.max' => 'Kode Jenis Pelatihan tidak boleh lebih dari 255 karakter.',
            'jenis_pelatihan.required' => 'Jenis Pelatihan wajib diisi.',
            'jenis_pelatihan.max' => 'Jenis Pelatihan tidak boleh lebih dari 255 karakter.',
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

        ref_jenispelatihans::create($request->all());

        return redirect()->back()->with([
            'message' => 'Jenis Pelatihan berhasil ditambahkan.',
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
        $jenispelatihan = ref_jenispelatihans::findOrFail($id);
        if (!$jenispelatihan) {
            return redirect()->back()->with([
                'message' => 'Jenis Pelatihan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }
        return view('dashboard.pengaturandasar.jenispelatihan.edit', compact('jenispelatihan'));
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
            'kode_jenispelatihan' => 'required|string|max:255|unique:ref_jenispelatihans,kode_jenispelatihan,' . $id,
            'jenis_pelatihan' => 'required|string|max:255',
        ], [
            'kode_jenispelatihan.required' => 'Kode Jenis Pelatihan wajib diisi.',
            'kode_jenispelatihan.unique' => 'Kode Jenis Pelatihan sudah digunakan.',
            'kode_jenispelatihan.max' => 'Kode Jenis Pelatihan tidak boleh lebih dari 255 karakter.',
            'jenis_pelatihan.required' => 'Jenis Pelatihan wajib diisi.',
            'jenis_pelatihan.max' => 'Jenis Pelatihan tidak boleh lebih dari 255 karakter.',
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

        $jenispelatihan = ref_jenispelatihans::findOrFail($id);
        $jenispelatihan->update($request->all());

        return redirect()->back()->with([
            'message' => 'Jenis Pelatihan berhasil diperbarui.',
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
        $jenispelatihan = ref_jenispelatihans::findOrFail($id);
        if (!$jenispelatihan) {
            return redirect()->back()->with([
                'message' => 'Jenis Pelatihan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        $jenispelatihan->delete();

        return redirect()->back()->with([
            'message' => 'Jenis Pelatihan berhasil dihapus.',
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
                'name' => 'kode_jenispelatihan',
                'label' => 'Kode Jenis Pelatihan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: JP001',
            ],
            [
                'name' => 'jenis_pelatihan',
                'label' => 'Jenis Pelatihan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: Pelatihan Dasar CPNS',
            ],
        ];
    }
}
