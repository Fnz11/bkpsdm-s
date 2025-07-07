<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_pelaksanaanpelatihans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefPelaksanaanPelatihanController extends Controller
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

        $pelaksanaanpelatihans = ref_pelaksanaanpelatihans::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('pelaksanaan_pelatihan', 'like', "%{$search}%")
                    ->orWhere('kode_pelaksanaanpelatihan', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_pelaksanaanpelatihan')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.pelaksanaanpelatihan.index', compact('pelaksanaanpelatihans'))->render();
        }

        return view('dashboard.pengaturandasar.pelaksanaanpelatihan.index', compact('pelaksanaanpelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.pelaksanaanpelatihan.create');
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
            'kode_pelaksanaanpelatihan' => 'required|string|max:255|unique:ref_pelaksanaanpelatihans,kode_pelaksanaanpelatihan',
            'pelaksanaan_pelatihan' => 'required|string|max:255',
        ], [
            'kode_pelaksanaanpelatihan.required' => 'Kode Pelaksanaan Pelatihan wajib diisi.',
            'kode_pelaksanaanpelatihan.unique' => 'Kode Pelaksanaan Pelatihan sudah digunakan.',
            'kode_pelaksanaanpelatihan.max' => 'Kode Pelaksanaan Pelatihan tidak boleh lebih dari 255 karakter.',
            'pelaksanaan_pelatihan.required' => 'Pelaksanaan Pelatihan wajib diisi.',
            'pelaksanaan_pelatihan.max' => 'Pelaksanaan Pelatihan tidak boleh lebih dari 255 karakter.',
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

        ref_pelaksanaanpelatihans::create($request->only(['kode_pelaksanaanpelatihan', 'pelaksanaan_pelatihan']));

        return redirect()->back()->with([
            'message' => 'Pelaksanaan Pelatihan berhasil ditambahkan.',
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
        $pelaksanaanpelatihan = ref_pelaksanaanpelatihans::findOrFail($id);
        return view('dashboard.pengaturandasar.pelaksanaanpelatihan.edit', compact('pelaksanaanpelatihan'));
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
            'kode_pelaksanaanpelatihan' => 'required|string|max:255|unique:ref_pelaksanaanpelatihans,kode_pelaksanaanpelatihan,' . $id,
            'pelaksanaan_pelatihan' => 'required|string|max:255',
        ], [
            'kode_pelaksanaanpelatihan.required' => 'Kode Pelaksanaan Pelatihan wajib diisi.',
            'kode_pelaksanaanpelatihan.unique' => 'Kode Pelaksanaan Pelatihan sudah digunakan.',
            'kode_pelaksanaanpelatihan.max' => 'Kode Pelaksanaan Pelatihan tidak boleh lebih dari 255 karakter.',
            'pelaksanaan_pelatihan.required' => 'Pelaksanaan Pelatihan wajib diisi.',
            'pelaksanaan_pelatihan.max' => 'Pelaksanaan Pelatihan tidak boleh lebih dari 255 karakter.',
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

        $pelaksanaanpelatihan = ref_pelaksanaanpelatihans::findOrFail($id);
        $pelaksanaanpelatihan->update($request->only(['kode_pelaksanaanpelatihan', 'pelaksanaan_pelatihan']));

        return redirect()->back()->with([
            'message' => 'Pelaksanaan Pelatihan berhasil diperbarui.',
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
        $pelaksanaanpelatihan = ref_pelaksanaanpelatihans::findOrFail($id);
        if (!$pelaksanaanpelatihan) {
            return redirect()->back()->with([
                'message' => 'Pelaksanaan Pelatihan tidak ditemukan.',
                'title' => 'Error',
            ]);
        }
        $pelaksanaanpelatihan->delete();

        return redirect()->back()->with([
            'message' => 'Pelaksanaan Pelatihan berhasil dihapus.',
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
                'name' => 'kode_pelaksanaanpelatihan',
                'label' => 'Kode Pelaksanaan Pelatihan',
                'type' => 'text',
                'required' => true
            ],
            [
                'name' => 'pelaksanaan_pelatihan',
                'label' => 'Pelaksanaan Pelatihan',
                'type' => 'text',
                'required' => true
            ],
        ];
    }
}
