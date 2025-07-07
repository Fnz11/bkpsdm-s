<?php

namespace App\Http\Controllers\Admin\DatabaseEkatalog;
use App\Http\Controllers\Controller;
use App\Models\ref_namajabatanasns;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_golongans;
use App\Models\ref_kategorijabatans;
use App\Models\ref_unitkerjas;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    // In your Controller
// In your PelatihanController (or equivalent controller)
public function index()
{
    $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all(); // Ganti dengan model yang sesuai
    $jenisPelatihan = ref_jenispelatihans::all(); // Ganti dengan model yang sesuai
    $metodePelatihan = ref_metodepelatihans::all(); // Ganti dengan model yang sesuai
    $golongan = ref_golongans::all(); // Ganti dengan model yang sesuai
    $unit_Kerja = ref_unitkerjas::all(); // Ganti dengan model yang sesuai
    $jabatan = ref_kategorijabatans::all(); // Ganti dengan model yang sesuai


    return view('Admin.ekatalog.database', compact(
        'pelaksanaanPelatihan', 
        'jenisPelatihan', 
        'metodePelatihan', 
        'golongan', 
        'unit_Kerja',
        'jabatan',
    ));
}



    public function create()
    {
        $existingCodes = [
            'kodePelaksanaan' => ref_pelaksanaanpelatihans::pluck('kode_pelaksanaanpelatihan')->toArray(),
            'kodePelatihan' => ref_jenispelatihans::pluck('kode_pelatihan')->toArray(),
            'kodeMetode' => ref_metodepelatihans::pluck('kode_pelatihan')->toArray(),
            'kodeGolongan' => ref_golongans::pluck('kode_golongan')->toArray(),
            'kodeJabatan' => ref_namajabatanasns::pluck('kode_kategorijabatan')->toArray(),
            'kodeUnitKerja' => ref_unitkerjas::pluck('kode_unitkerja')->toArray(),
        ];
    
        return view('ekatalog.createpelatihan', compact('existingCodes'));
    }


    public function store(Request $request, $type)
    {
        // Define validation rules for each table type
        $validationRules = [
            'pelaksanaan' => [
                'kode_pelaksanaanpelatihan' => 'required|numeric|max:99999',  // Hanya angka
                'pelaksanaan_pelatihan' => 'required|string|max:255',
            ],
            'jenis' => [
                'kode_jenispelatihan' => 'required|numeric|max:99999',  // Hanya angka
                'jenis_pelatihan' => 'required|string|max:255',
            ],
            'metode' => [
                'kode_metodepelatihan' => 'required|numeric|max:99999',  // Hanya angka
                'metode_pelatihan' => 'required|string|max:255',
            ],
            'golongan' => [
                'kode_golongan' => 'required|numeric|max:99999',  // Hanya angka
                'golongan' => 'required|string|max:255',
                'pangkat' => 'required|string|max:255',
            ],
            'unitkerja' => [
                'kode_unitkerja' => 'required|numeric|max:99999',  // Hanya angka
                'sub_unitkerja' => 'required|string|max:255',
                'unit_kerja' => 'required|string|max:255',
                'singkatan' => 'required|string|max:255',
            ],
            'jabatan' => [
                'kode_kategorijabatan' => 'required|numeric|max:99999',  // Hanya angka
                'kategori_jabatan' => 'required|string|max:255',
            ]
        ];
    
        // Validate the incoming data based on the selected table type
        $validatedData = $request->validate($validationRules[$type]);
    
        // Define the model class and unique field for each type
        $modelClassMap = [
            'pelaksanaan' => [ref_pelaksanaanpelatihans::class, 'kode_pelaksanaanpelatihan'],
            'jenis' => [ref_jenispelatihans::class, 'kode_jenispelatihan'],
            'metode' => [ref_metodepelatihans::class, 'kode_metodepelatihan'],
            'golongan' => [ref_golongans::class, 'kode_golongan'],
            'unitkerja' => [ref_unitkerjas::class, 'kode_unitkerja'],
            'jabatan' => [ref_kategorijabatans::class, 'kode_kategorijabatan'],
        ];
    
        if (!isset($modelClassMap[$type])) {
            return redirect()->route('admin.ekatalog.database')->with('error', 'Invalid table type');
        }
    
        [$modelClass, $uniqueField] = $modelClassMap[$type];
    
        // Check if the unique code already exists
        if ($modelClass::where($uniqueField, $validatedData[$uniqueField])->exists()) {
            return redirect()->back()->with('error', "Kode $uniqueField sudah ada. Gunakan kode yang berbeda.");
        }
    
        // Insert the validated data into the correct table
        $modelClass::create($validatedData);
    
        // Redirect back with a success message
        return redirect()->route('Admin.ekatalog.database')->with('success', ucfirst($type) . ' added successfully!');
    }
    
    


// PelatihanController.php
public function delete($model, $id)
{
    try {
        // Membuat nama kelas model secara dinamis
        $modelClass = 'App\\Models\\' . $model;

        // Pastikan model tersebut ada di dalam namespace App\Models
        if (!class_exists($modelClass)) {
            return redirect()->back()->with('error', 'Model not found');
        }

        // Membuat instance dari model untuk mendapatkan informasi tentang primary key
        $modelInstance = new $modelClass;

        // Periksa apakah primary key berbeda dengan default 'id'
        $primaryKey = $modelInstance->getKeyName();

        // Mencari item berdasarkan ID dan primary key yang sesuai
        $item = $modelClass::where($primaryKey, $id)->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        // Hapus item
        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    } catch (\Exception $e) {
        // Menangkap error dan memberikan feedback
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}







}
