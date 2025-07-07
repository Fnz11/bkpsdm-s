<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Pendaftaran;
use App\Models\PelatihanList;
use App\Models\PelatihanRegistrasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use ZipStream\Option\Archive;
use ZipStream\ZipStream;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DeepwarePelatihanRegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all pelatihan registrasi data
        $pelatihanRegistrasi = Pelatihan2Pendaftaran::with([
            'user',
            'pelatihan',
        ])->get();

        // Return the view with pelatihan registrasi data
        return view('dashboard.pelatihan.usul-pelatihan', compact('pelatihanRegistrasi'));
    }

    public function showVerifikasiRegistrasi(PelatihanRegistrasi $pelatihanRegistrasi)
    {
        // Show the verification page for the specified pelatihan
        return view('dashboard.pelatihan.verifikasi-pelatihan', compact('pelatihanRegistrasi'));
    }

    public function uploadSuratOPD($id)
    {
        // Fetch the pelatihan registrasi by ID
        $pelatihanRegistrasi = PelatihanRegistrasi::with([
            'user.userPivot.golongan',
            'user.userPivot.unitKerja',
            'user.userPivot.jabatan',
            'pelatihan'
        ])->findOrFail($id);

        // Check if the pelatihan registrasi exists
        if (!$pelatihanRegistrasi) {
            return redirect()->back()->with('error', 'Pelatihan registrasi not found.');
        }

        // Show the verification page for the specified pelatihan
        return view('dashboard.pelatihan.verifikasi-pelatihan', compact('pelatihanRegistrasi'));
    }

    public function exportRegistrasi()
    {
        // Fetch all pelatihan registrasi data
        $registrasis = PelatihanRegistrasi::with([
            'user.userPivot.golongan',
            'user.userPivot.unitKerja',
            'user.userPivot.jabatan',
            'pelatihan'
        ])->get();

        // Return the view with pelatihan registrasi data
        return view('dashboard.pelatihan.laporan-registrasi', compact('registrasis'));
    }

    public function suratOPD(PelatihanRegistrasi $pelatihanRegistrasi)
    {
        $pdf = Pdf::loadView('dashboard.pdf.surat-opd', compact('pelatihanRegistrasi'))->setPaper('A4', 'portrait');
        return $pdf->stream('surat-pendaftaran.pdf');
    }

    public function bulkDownloadPdf(Request $request)
    {
        $ids = $request->input('selected_ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Silakan pilih setidaknya satu data.');
        }

        return response()->streamDownload(function () use ($ids) {
            if (ob_get_length()) {
                ob_end_clean();
            }

            $zip = new ZipStream();

            foreach ($ids as $id) {
                $data = PelatihanRegistrasi::with([
                    'user.userPivot.unitKerja',
                    'user.userPivot.jabatan',
                    'user.userPivot.golongan',
                    'pelatihan'
                ])->findOrFail($id);

                $pdf = Pdf::loadView('dashboard.pdf.surat-opd', compact('data'))->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                $zip->addFile("registrasi_{$id}.pdf", $pdfContent);
            }

            $zip->finish();
        }, 'pelatihan_registrasi.zip');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all pelatihan data
        $pelatihan = PelatihanList::all();

        // Return the view with pelatihan data
        return view('admin.pelatihan.registrasi.create', compact('pelatihan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nip' => 'required|exists:ref_pegawais,nip',
            'id_pelatihan' => 'required|exists:pelatihan_lists,id',
            'tanggal_daftar' => 'required|date',
            'biaya_akomodasi' => 'nullable|numeric',
            'biaya_hotel' => 'nullable|numeric',
            'biaya_pelatihan' => 'nullable|numeric',
            'uang_harian' => 'nullable|numeric',
            'file_usulan' => 'nullable|file|mimes:pdf|max:2048',
            'file_penawaran' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Create a new pelatihan registrasi
        PelatihanRegistrasi::create($request->all());

        // Redirect to the index page with success message
        return redirect()->route('pelatihan.registrasi.index')->with('success', 'Pelatihan registrasi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PelatihanRegistrasi $pelatihanRegistrasi)
    {
        // Show the details of the specified pelatihan registrasi
        return view('admin.pelatihan.registrasi.show', compact('pelatihanRegistrasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PelatihanRegistrasi $pelatihanRegistrasi)
    {
        // Fetch all pelatihan data
        $pelatihan = PelatihanList::all();

        // Return the view with pelatihan registrasi and pelatihan data
        return view('admin.pelatihan.registrasi.edit', compact('pelatihanRegistrasi', 'pelatihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PelatihanRegistrasi $pelatihanRegistrasi)
    {
        // Validate the request data
        $request->validate([
            'nip' => 'required|exists:ref_pegawais,nip',
            'id_pelatihan' => 'required|exists:pelatihan_lists,id',
            'tanggal_daftar' => 'required|date',
            'biaya_akomodasi' => 'nullable|numeric',
            'biaya_hotel' => 'nullable|numeric',
            'biaya_pelatihan' => 'nullable|numeric',
            'uang_harian' => 'nullable|numeric',
            'file_usulan' => 'nullable|file|mimes:pdf|max:2048',
            'file_penawaran' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Update the pelatihan registrasi
        $pelatihanRegistrasi->update($request->all());

        // Redirect to the index page with success message
        return redirect()->route('pelatihan.registrasi.index')->with('success', 'Pelatihan registrasi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PelatihanRegistrasi $pelatihanRegistrasi)
    {
        // Delete the pelatihan registrasi
        $pelatihanRegistrasi->delete();

        // Redirect to the index page with success message
        return redirect()->route('pelatihan.registrasi.index')->with('success', 'Pelatihan registrasi deleted successfully.');
    }
}
