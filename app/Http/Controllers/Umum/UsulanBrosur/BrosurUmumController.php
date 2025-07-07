<?php

namespace App\Http\Controllers\Umum\UsulanBrosur;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Brosur_2_masuk;
use App\Http\Controllers\Controller;


class BrosurUmumController extends Controller
{
    public function create()
    {
        return view('MenuUmum.BrosurPelatihan.createusulan');
    }

    public function index(Request $request)
    {
        // Ambil input pencarian dan bersihkan spasi berlebih
        $search = trim($request->input('search')); // Pencarian berdasarkan nama penyelenggara
        $searchYear = trim($request->input('tahun')); // Pencarian berdasarkan tahun

        // Ambil daftar tahun yang ada dalam data hanya dari status "diterima"
        $years = Brosur_2_masuk::where('status', 'diterima') // Hanya ambil tahun dari data "diterima"
            ->whereNotNull('created_at') // Pastikan tanggal tidak null
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Query data dengan filter pencarian, hanya yang statusnya "diterima"
        $usulan = Brosur_2_masuk::where('status', 'diterima') // Hanya ambil data yang "diterima"
            ->when($search, function ($query, $search) {
                return $query->where('nama_penyelenggara', 'like', "%$search%");
            })
            ->when($searchYear, function ($query, $searchYear) {
                return $query->whereYear('created_at', $searchYear);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query()); // Memastikan parameter pencarian tetap ada di paginasi

        // Log jika ada pencarian
        if ($search || $searchYear) {
            Log::info('Pencarian data usulan (hanya diterima)', [
                'search' => $search,
                'tahun' => $searchYear,
                'jumlah_ditemukan' => $usulan->total()
            ]);
        }

        // Return view dengan data
        return view('MenuUmum.BrosurPelatihan.usulan', compact('usulan', 'search', 'searchYear', 'years'));
    }



    public function store(Request $request)
    {
        Log::info('Form submitted', $request->all());

        // Validasi input dan file
        $request->validate([
            'nama_penyelenggara' => 'required',
            'alamat' => 'required',
            'nama_sales' => 'required',
            'no_hp' => 'required',
            'no_surat' => 'required',
            'tanggal_surat' => 'nullable',
            'brosur_excel' => 'nullable|mimes:xlsx,xls|max:2048',
            'brosur_pdf' => 'nullable|mimes:pdf|max:2048',
            'status' => 'nullable',
        ]);

        // Simpan data usulan diklat
        $usulan_diklat = new Brosur_2_masuk();
        $usulan_diklat->nama_penyelenggara = $request->nama_penyelenggara;
        $usulan_diklat->alamat = $request->alamat;
        $usulan_diklat->nama_sales = $request->nama_sales;
        $usulan_diklat->no_hp = $request->no_hp;
        $usulan_diklat->tanggal_surat = $request->tanggal_surat;
        $usulan_diklat->no_surat = $request->no_surat;
        $usulan_diklat->status = $request->status ?? 'proses verifikasi';

        // Cek apakah file berhasil diupload
        if ($request->hasFile('brosur_pdf')) {
            Log::info('PDF file uploaded');
            $pdf = $request->file('brosur_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('uploads/pdf'), $pdfName);
            $usulan_diklat->brosur_pdf = 'uploads/pdf/' . $pdfName;
        } else {
            Log::info('No PDF file uploaded');
        }

        if ($request->hasFile('brosur_excel')) {
            Log::info('Excel file uploaded');
            $excel = $request->file('brosur_excel');
            $excelName = time() . '_' . $excel->getClientOriginalName();
            $excel->move(public_path('uploads/excel'), $excelName);
            $usulan_diklat->brosur_excel = 'uploads/excel/' . $excelName;
        } else {
            Log::info('No Excel file uploaded');
        }

        // Simpan data ke database
        $usulan_diklat->save();
        Log::info('Data saved to database');

        // Redirect dengan success message
        // return redirect()->back()->with('success', 'Input berhasil. Menunggu verifikasi dari BKPSDM KOTA SURAKARTA.');
        return redirect()->back()->with([
            'success' => 'Input berhasil. Menunggu verifikasi dari BKPSDM KOTA SURAKARTA.',
            'redirect_to_home' => true
        ]);

    }
}
