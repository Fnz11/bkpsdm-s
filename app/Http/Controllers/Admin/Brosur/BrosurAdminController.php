<?php

namespace App\Http\Controllers\Admin\Brosur;

use App\Http\Controllers\Controller;
use App\Models\Brosur_2_masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrosurAdminController extends Controller
{
    // Menampilkan data brosur dengan filter dan pagination
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        if ($routeName === 'Admin.Brosur.arsip') {
            $statusFilter = ['diterima', 'ditolak']; // Arsip hanya menampilkan yang "diterima"
        } else {
            $statusFilter = ['proses verifikasi',]; // Usulan menampilkan "proses verifikasi" dan "ditolak"
        }

        $search = trim($request->input('search'));
        $searchYear = trim($request->input('tahun'));

        // Ambil daftar tahun dari `tanggal_surat`
        $years = Brosur_2_masuk::whereIn('status', $statusFilter)
            ->whereNotNull('tanggal_surat')
            ->selectRaw('YEAR(tanggal_surat) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Query untuk data brosur
        $brosur_2_masuks = Brosur_2_masuk::whereIn('status', $statusFilter)
            ->when($search, function ($query, $search) {
                return $query->where('nama_penyelenggara', 'like', "%$search%");
            })
            ->when($searchYear, function ($query, $searchYear) {
                return $query->whereYear('tanggal_surat', $searchYear);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        // Tentukan tampilan yang akan digunakan
        $viewName = ($routeName === 'Admin.Brosur.arsip') ? 'Admin.Brosur.arsip' : 'Admin.Brosur.usulan';

        return view($viewName, compact('brosur_2_masuks', 'search', 'searchYear', 'years'));
    }

    // Menampilkan form tambah brosur
    public function create()
    {
        // Definisi status manual
        $statusList = ['proses verifikasi', 'diterima', 'ditolak'];

        return view('Admin.Brosur.create', compact('statusList'));
    }
    


    // Menyimpan data brosur baru
    public function storebrosur(Request $request)
    {
        $request->validate([
            'nama_penyelenggara' => 'required',
            'alamat' => 'required',
            'nama_sales' => 'required',
            'no_hp' => 'required',
            'no_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'brosur_excel' => 'nullable|mimes:xlsx,xls|max:2048',
            'brosur_pdf' => 'nullable|mimes:pdf|max:2048',
            'status' => 'required',
        ]);

        $brosur = new Brosur_2_masuk();
        $brosur->nama_penyelenggara = $request->nama_penyelenggara;
        $brosur->alamat = $request->alamat;
        $brosur->nama_sales = $request->nama_sales;
        $brosur->no_hp = $request->no_hp;
        $brosur->no_surat = $request->no_surat;
        $brosur->tanggal_surat = $request->tanggal_surat;
        $brosur->status = $request->status;

        // Simpan file jika ada
        if ($request->hasFile('brosur_pdf')) {
            $pdf = $request->file('brosur_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('uploads/pdf'), $pdfName);
            $brosur->brosur_pdf = 'uploads/pdf/' . $pdfName;
        }

        if ($request->hasFile('brosur_excel')) {
            $excel = $request->file('brosur_excel');
            $excelName = time() . '_' . $excel->getClientOriginalName();
            $excel->move(public_path('uploads/excel'), $excelName);
            $brosur->brosur_excel = 'uploads/excel/' . $excelName;
        }

        $brosur->save();

        return redirect()->route('Admin.Brosur.usulan')->with('success', 'Usulan brosur berhasil ditambahkan.');
    }

    // Menampilkan form edit brosur
    public function edit($id)
    {
        $brosur = Brosur_2_masuk::findOrFail($id);
        $statusList = Brosur_2_masuk::select('status')->distinct()->pluck('status');

        return view('Admin.Brosur.editbrosur', compact('brosur', 'statusList'));
    }

    // Menyimpan perubahan pada brosur
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_penyelenggara' => 'required',
                'alamat' => 'required',
                'nama_sales' => 'required',
                'no_hp' => 'required',
                'no_surat' => 'required',
                'tanggal_surat' => 'required|date',
                'brosur_excel' => 'nullable|mimes:xlsx,xls|max:2048',
                'brosur_pdf' => 'nullable|mimes:pdf|max:2048',
            ]);

            $brosur = Brosur_2_masuk::findOrFail($id);
            $brosur->nama_penyelenggara = $request->nama_penyelenggara;
            $brosur->alamat = $request->alamat;
            $brosur->nama_sales = $request->nama_sales;
            $brosur->no_hp = $request->no_hp;
            $brosur->no_surat = $request->no_surat;
            $brosur->tanggal_surat = $request->tanggal_surat;

            // Simpan file jika ada
            if ($request->hasFile('brosur_pdf')) {
                $pdf = $request->file('brosur_pdf');
                $pdfName = time() . '_' . $pdf->getClientOriginalName();
                $pdf->move(public_path('uploads/pdf'), $pdfName);
                $brosur->brosur_pdf = 'uploads/pdf/' . $pdfName;
            }

            if ($request->hasFile('brosur_excel')) {
                $excel = $request->file('brosur_excel');
                $excelName = time() . '_' . $excel->getClientOriginalName();
                $excel->move(public_path('uploads/excel'), $excelName);
                $brosur->brosur_excel = 'uploads/excel/' . $excelName;
            }

            $brosur->save();

            return redirect()->route('Admin.Brosur.usulan')->with('success', 'Data brosur berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menghapus brosur
    public function deletes($id)
    {
        $brosur = Brosur_2_masuk::where('id', $id)->firstOrFail();

        // Hapus file PDF jika ada
        if ($brosur->brosur_pdf && Storage::exists($brosur->brosur_pdf)) {
            Storage::delete($brosur->brosur_pdf);
        }

        // Hapus file Excel jika ada
        if ($brosur->brosur_excel && Storage::exists($brosur->brosur_excel)) {
            Storage::delete($brosur->brosur_excel);
        }

        // Hapus data dari database
        $brosur->delete();

        return redirect()->route('Admin.Brosur.usulan')->with('success', 'Brosur berhasil dihapus.');
    }

    // Menyetujui brosur
    public function approve($id)
    {
        $brosur = Brosur_2_masuk::findOrFail($id);
        $brosur->status = 'diterima';
        $brosur->save();

        return redirect()->route('Admin.Brosur.usulan')->with('success', 'Brosur berhasil disetujui.');
    }
}
