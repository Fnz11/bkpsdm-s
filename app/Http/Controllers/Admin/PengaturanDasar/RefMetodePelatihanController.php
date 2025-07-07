<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_metodepelatihans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefMetodePelatihanController extends Controller
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

        $metodepelatihans = ref_metodepelatihans::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('metode_pelatihan', 'like', "%{$search}%")
                    ->orWhere('kode_metodepelatihan', 'like', "%{$search}%");
            });
        })
            ->orderBy('kode_metodepelatihan')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.metodepelatihan.index', compact('metodepelatihans'))->render();
        }

        return view('dashboard.pengaturandasar.metodepelatihan.index', compact('metodepelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.pengaturandasar.metodepelatihan.create');
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
            'kode_metodepelatihan' => 'required|string|max:255|unique:ref_metodepelatihans,kode_metodepelatihan',
            'metode_pelatihan' => 'required|string|max:255',
        ], [
            'kode_metodepelatihan.required' => 'Kode Metode Pelatihan wajib diisi.',
            'kode_metodepelatihan.unique' => 'Kode Metode Pelatihan sudah digunakan.',
            'kode_metodepelatihan.max' => 'Kode Metode Pelatihan tidak boleh lebih dari 255 karakter.',
            'metode_pelatihan.required' => 'Nama Metode Pelatihan wajib diisi.',
            'metode_pelatihan.max' => 'Nama Metode Pelatihan tidak boleh lebih dari 255 karakter.',
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

        ref_metodepelatihans::create($request->all());

        return redirect()->back()->with([
            'message' => 'Metode Pelatihan berhasil ditambahkan.',
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
        $metodepelatihan = ref_metodepelatihans::findOrFail($id);
        if (!$metodepelatihan) {
            return redirect()->route('dashboard.pelatihan.metodepelatihan')
                ->with([
                    'message' => 'Metode Pelatihan not found.',
                    'title' => 'Error',
                ]);
        }
        return view('dashboard.pengaturandasar.metodepelatihan.edit', compact('metodepelatihan'));
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
            'kode_metodepelatihan' => 'required|string|max:255|unique:ref_metodepelatihans,kode_metodepelatihan,' . $id,
            'metode_pelatihan' => 'required|string|max:255',
        ], [
            'kode_metodepelatihan.required' => 'Kode Metode Pelatihan wajib diisi.',
            'kode_metodepelatihan.unique' => 'Kode Metode Pelatihan sudah digunakan.',
            'kode_metodepelatihan.max' => 'Kode Metode Pelatihan tidak boleh lebih dari 255 karakter.',
            'metode_pelatihan.required' => 'Nama Metode Pelatihan wajib diisi.',
            'metode_pelatihan.max' => 'Nama Metode Pelatihan tidak boleh lebih dari 255 karakter.',
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

        $metodepelatihan = ref_metodepelatihans::findOrFail($id);
        $metodepelatihan->update($request->all());

        return redirect()->back()->with([
            'message' => 'Metode Pelatihan berhasil diperbarui.',
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
        $metodepelatihan = ref_metodepelatihans::findOrFail($id);
        if (!$metodepelatihan) {
            return redirect()->route('dashboard.pelatihan.metodepelatihan')->with('error', 'Metode Pelatihan not found.');
        }

        $metodepelatihan->delete();

        return redirect()->back()->with([
            'message' => 'Metode Pelatihan berhasil dihapus.',
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
                'name' => 'kode_metodepelatihan',
                'label' => 'Kode Metode Pelatihan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: MP001',
            ],
            [
                'name' => 'metode_pelatihan',
                'label' => 'Nama Metode Pelatihan',
                'type' => 'text',
                'required' => true,
                'col' => 12,
                'placeholder' => 'Contoh: Tatap Muka',
            ],
        ];
    }
}
