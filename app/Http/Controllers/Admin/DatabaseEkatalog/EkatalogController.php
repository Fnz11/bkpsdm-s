<?php

namespace App\Http\Controllers\Admin\DatabaseEkatalog;
use App\Http\Controllers\Controller;

use App\Models\Katalog_2_masuks;
use App\Models\ref_kategorijabatans;
use App\Models\ref_metodepelatihans;
use Illuminate\Http\Request;

class EkatalogController extends Controller
{
    // Display a list of Diklat entries with search functionality
    public function index(Request $request)
    {
        // Tangkap nilai pencarian, hilangkan spasi ekstra
        $search = trim($request->input('search'));
    
        // Query untuk mengambil data diklat berdasarkan pencarian (jika ada)
        $diklats = Katalog_2_masuks::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jenis_pelatihan', 'LIKE', "%{$search}%")
                      ->orWhere('nama_pelatihan', 'LIKE', "%{$search}%")
                      ->orWhere('rumpun_pelatihan', 'LIKE', "%{$search}%")
                      ->orWhere('nama_penyelenggara', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        // Kembalikan ke tampilan dengan data yang sudah difilter
        return view('admin.ekatalog.diklat', compact('diklats'));
    }
    
    

    // Show the form for creating a new Diklat
    public function create()
{
    $jabatan = ref_kategorijabatans::all();
    $metodePelaksanaan = ref_metodepelatihans::all();
    return view('admin.ekatalog.creatediklat', compact('jabatan', 'metodePelaksanaan'));
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'rumpun_pelatihan'        => 'required|string|max:255',
        'jenis_pelatihan'         => 'required|string|max:255',
        'nama_pelatihan'          => 'required|string|max:255',
        'informasi_pelatihan'     => 'nullable|string',
        'file_pelatihan'          => 'required|file|mimes:pdf|max:2048',
        'estimasi_biaya'          => 'required|numeric',
        'nama_penyelenggara'      => 'required|string|max:255',
        'nama_CP'                 => 'required|string|max:255',
        'no_HP'                   => 'required|regex:/^[0-9]+$/|max:15',
        'metode_pelatihan'        => 'required|string|max:255',
        'pelaksanaan_pelatihan'   => 'required|string|max:255',
        'status'                  => 'required|in:hide,visible',
        'keterangan'              => 'nullable|string',
    ]);

    // Simpan file
    $filePath = $request->file('file_pelatihan')->storeAs(
        'pelatihan_files',
        time() . '_' . $request->file('file_pelatihan')->getClientOriginalName(),
        'public'
    );

    // Simpan ke database
    $data = Katalog_2_masuks::create([
        'rumpun_pelatihan'      => strip_tags($validatedData['rumpun_pelatihan']),
        'jenis_pelatihan'       => strip_tags($validatedData['jenis_pelatihan']),
        'nama_pelatihan'        => strip_tags($validatedData['nama_pelatihan']),
        'informasi_pelatihan'   => strip_tags($validatedData['informasi_pelatihan'] ?? ''),
        'file_pelatihan'        => $filePath,
        'estimasi_biaya'        => $validatedData['estimasi_biaya'],
        'nama_penyelenggara'    => strip_tags($validatedData['nama_penyelenggara']),
        'nama_CP'               => strip_tags($validatedData['nama_CP']),
        'no_HP'                 => $validatedData['no_HP'],
        'metode_pelatihan'      => strip_tags($validatedData['metode_pelatihan']),
        'pelaksanaan_pelatihan' => strip_tags($validatedData['pelaksanaan_pelatihan']),
        'status'                => $validatedData['status'],
        'keterangan'            => strip_tags($validatedData['keterangan'] ?? ''),
    ]);

    // Cek apakah id tersedia sebelum redirect
    if (!$data->id) {
        return redirect()->back()->with('error', 'Gagal menyimpan data pelatihan.');
    }

    return redirect()->route('admin.ekatalog.diklat', ['id' => $data->id])
        ->with('success', 'Data pelatihan berhasil disimpan.');
}





    
    

    // Show the form for editing a Diklat
    public function edit($id)
    {
        $diklat = Katalog_2_masuks::findOrFail($id);
        return view('admin.ekatalog.editdiklat', compact('diklat'));
    }

    // Update a Diklat entry in the database
    public function update(Request $request, $id)
{
    // Validate the form data
    $request->validate([
        'jenis_pelatihan' => 'required|string|max:255',
        'nama_pelatihan' => 'required|string|max:255',
        'rumpun_pelatihan' => 'required|string|max:255',
        'nama_penyelenggaraan' => 'required|string|max:255',
        'no_hp' => 'required|string|max:15',
        'estimasi_biaya' => 'required|numeric',
        'file_pelatihan' => 'nullable|file|mimes:pdf|max:2048', // Hanya PDF, maksimal 2MB
        'status' => 'required|string|max:50',
    ]);

    // Find the Pelatihan record
    $pelatihan = Katalog_2_masuks::findOrFail($id);

    // Handle file upload if a new file is provided
    if ($request->hasFile('file_pelatihan')) {
        $filePath = $request->file('file_pelatihan')->store('pelatihan_files', 'public');
        $pelatihan->file_pelatihan = $filePath;
    }

    // Update the Pelatihan record
    $pelatihan->update([
        'jenis_pelatihan' => $request->jenis_pelatihan,
        'nama_pelatihan' => $request->nama_pelatihan,
        'rumpun_pelatihan' => $request->rumpun_pelatihan,
        'nama_penyelenggaraan' => $request->nama_penyelenggaraan,
        'no_hp' => $request->no_hp,
        'estimasi_biaya' => $request->estimasi_biaya,
        'status' => $request->status,
    ]);

    // Redirect to the Pelatihan list with a success message
    return redirect()->route('pelatihan.index')->with('success', 'Pelatihan successfully updated.');
}


    // Delete a Diklat entry from the database
    public function destroy($id_katalog2)
    {
        $diklat = Katalog_2_masuks::findOrFail($id_katalog2);
        $diklat->delete();

        // Redirect to the Diklat list with a success message
        return redirect()->route('admin.ekatalog.diklat')->with('success', 'Diklat successfully deleted.');
    }

    public function view($id_katalog2)
    {
        // Retrieve the Diklat entry by its ID
        $diklat = Katalog_2_masuks::findOrFail($id_katalog2);

        // Pass the Diklat data to the viewdiklat view
        return view('admin.ekatalog.viewdiklat', compact('diklat'));
    }   

    public function toggleStatus($id_katalog2)
{
    $diklat = Katalog_2_masuks::findOrFail($id_katalog2);
    $diklat->status = $diklat->status == 'visible' ? 'hide' : 'visible';
    $diklat->save();

    return redirect()->back()->with('success', 'Status berhasil diubah.');
}

}
