<?php

namespace App\Http\Controllers\Admin\Evaluasi;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        if ($request->has('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        $pertanyaan = $query->paginate(10);

        return view('Admin.Evaluasi.pertanyaan', compact('pertanyaan'));
    }

    public function destroy($id)
    {
        $item = Pertanyaan::findOrFail($id);
        $item->delete();

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function create()
    {
        return view('Admin.Evaluasi.createpertanyaan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jenispelatihan' => 'required|in:JP001,JP002,JP003,JP004',
            'kode_kategoripertanyaan' => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:1000',
        ]);

        Pertanyaan::create($request->all());

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);
    return view('Admin.Evaluasi.editpertanyaan', compact('pertanyaan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'kode_jenispelatihan' => 'required|string|max:255',
        'kode_kategoripertanyaan' => 'required|string|max:255',
        'pertanyaan' => 'required|string|max:1000',
    ]);

    $pertanyaan = Pertanyaan::findOrFail($id);
    $pertanyaan->update($request->all());

    return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
}


}
