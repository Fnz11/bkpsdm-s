<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan4Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class PelatihanLaporanUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userNip = Auth::user()->nip; // ambil NIP user login

        $laporans = Pelatihan4Laporan::with([
            'pendaftaran.user', 
            'pendaftaran.tersedia', 
            'pendaftaran.usulan'])
            // 'pendaftaran.tenggatUpload'])
            ->whereHas('pendaftaran', function ($query) use ($userNip) {
                $query->where('user_nip', $userNip); // filter data hanya milik user ini
            })
            ->when($search, function ($query, $search) {
                $query->where('judul_laporan', 'like', '%' . $search . '%')
                    ->orWhere('latar_belakang', 'like', '%' . $search . '%')
                    ->orWhere('total_biaya', 'like', '%' . $search . '%')
                    ->orWhere('hasil_pelatihan', 'like', '%' . $search . '%')
                    ->orWhereHas('pendaftaran.tersedia', function ($q) use ($search) {
                        $q->where('nama_pelatihan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.usulan', function ($q) use ($search) {
                        $q->where('nama_pelatihan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('pelatihan.laporan.index', compact('laporans'))->render();
        }

        return view('pelatihan.laporan.index', compact('laporans'));
    }


    public function show($id)
    {
        $laporan = Pelatihan4Laporan::with(['pendaftaran.user', 'pendaftaran.tersedia', 'pendaftaran.usulan'])
            ->findOrFail($id);

        return view('pelatihan.laporan.upload-laporan', compact('laporan'));
    }


    public function update(Request $request, $id)
    {
        $laporan = Pelatihan4Laporan::with(['pendaftaran.user'])
            ->whereHas('pendaftaran', function ($query) {
                $query->where('user_nip', Auth::user()->nip);
            })
            ->findOrFail($id);

        // Validasi untuk upload pertama kali (jika belum ada file)
        $rules = [
            'judul_laporan' => 'required|string|max:255',
            'latar_belakang' => 'required|string',
            'total_biaya' => 'required|numeric|min:0',
        ];

        // Jika belum ada file laporan, wajib upload
        if (!$laporan->laporan) {
            $rules['laporan'] = 'required|file|mimes:pdf,doc,docx|max:5120'; // 5MB
        } else {
            $rules['laporan'] = 'nullable|file|mimes:pdf,doc,docx|max:5120';
        }

        // Jika belum ada file sertifikat, wajib upload
        if (!$laporan->sertifikat) {
            $rules['sertifikat'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'; // 2MB
        } else {
            $rules['sertifikat'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $request->validate($rules);

        // Handle upload file laporan
        if ($request->hasFile('laporan')) {
            // Hapus file lama jika ada
            if ($laporan->laporan) {
                Storage::disk('public')->delete('laporan/' . $laporan->laporan);
            }

            $laporanFile = $request->file('laporan');
            $laporanPath = $laporanFile->store('laporan', 'public');
            $laporan->laporan = basename($laporanPath);
        }

        // Handle upload file sertifikat
        if ($request->hasFile('sertifikat')) {
            // Hapus file lama jika ada
            if ($laporan->sertifikat) {
                Storage::disk('public')->delete('sertifikat/' . $laporan->sertifikat);
            }

            $sertifikatFile = $request->file('sertifikat');
            $sertifikatPath = $sertifikatFile->store('sertifikat', 'public');
            $laporan->sertifikat = basename($sertifikatPath);
        }

        // Update status ke 'proses' jika sebelumnya 'draft' atau 'revisi'
        $currentStatus = strtolower($laporan->hasil_pelatihan);
        if (in_array($currentStatus, ['draft', 'revisi'])) {
            $laporan->hasil_pelatihan = 'proses';
        }
        // Update data laporan
        $laporan->update([
            'judul_laporan' => $request->judul_laporan,
            'latar_belakang' => $request->latar_belakang,
            'total_biaya' => $request->total_biaya,
        ]);

        // Jika ini adalah upload pertama kali, set status ke 'menunggu'
        if ($request->filled('laporan') && $request->filled('sertifikat') && $laporan->hasil_pelatihan == 'revisi') {
            // Reset status jika diperlukan
            // $laporan->update(['hasil_pelatihan' => 'menunggu']);
        }

        return redirect()->route('pelatihan.laporan')->with('success', 'Berkas berhasil diupload.');
    }

    // public function create()
    // {
    //     $pendaftarans = Pelatihan3Pendaftaran::with('user', 'pelatihan')->get();

    // public function create($pendaftaranId)
    // {
    //    $pendaftaran = Pelatihan3Pendaftaran::findOrFail($pendaftaranId);
    //     return view('pelatihan.laporan.create', compact('pendaftaran'));
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'pendaftaran_id' => 'required|exists:pelatihan_3_pendaftarans,id',
    //         'judul_laporan' => 'required|string|max:255',
    //         'latar_belakang' => 'required|string|max:255',
    //         'total_biaya' => 'required|numeric|min:0',
    //         'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
    //         'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //         'laporan' => 'required|file|mimes:pdf,docx|max:4096',
    //     ]);

    //     $sertifikatPath = $request->file('sertifikat')->store('sertifikat', 'public');
    //     $laporanPath = $request->file('laporan')->store('laporan', 'public');

    //     Pelatihan4Laporan::create([
    //         'pendaftaran_id' => $request->pendaftaran_id,
    //         'judul_laporan' => $request->judul_laporan,
    //         'latar_belakang' => $request->latar_belakang,
    //         'total_biaya' => $request->total_biaya,
    //         'hasil_pelatihan' => $request->hasil_pelatihan,
    //         'sertifikat' => basename($sertifikatPath),
    //         'laporan' => basename($laporanPath),
    //     ]);

    //     return redirect()->route('pelatihan.laporan')->with('success', 'Laporan berhasil ditambahkan.');
    // }

    // public function edit($id)
    // {
    //     $laporan = Pelatihan4Laporan::findOrFail($id);
    //     $pendaftarans = Pelatihan3Pendaftaran::with('user', 'pelatihan')->get();

    //     return view('dashboard.pelatihan.laporan.edit', compact('laporan', 'pendaftarans'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $laporan = Pelatihan4Laporan::findOrFail($id);

    //     $request->validate([
    //         'pendaftaran_id' => 'required|exists:pelatihan_3_pendaftarans,id',
    //         'judul_laporan' => 'required|string|max:255',
    //         'latar_belakang' => 'required|string|max:255',
    //         'total_biaya' => 'required|numeric|min:0',
    //         'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
    //         'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //         'laporan' => 'nullable|file|mimes:pdf,docx|max:4096',
    //     ]);

    //     if ($request->hasFile('sertifikat')) {
    //         Storage::disk('public')->delete('sertifikat/' . $laporan->sertifikat);
    //         $laporan->sertifikat = basename($request->file('sertifikat')->store('sertifikat', 'public'));
    //     }

    //     if ($request->hasFile('laporan')) {
    //         Storage::disk('public')->delete('laporan/' . $laporan->laporan);
    //         $laporan->laporan = basename($request->file('laporan')->store('laporan', 'public'));
    //     }

    //     $laporan->update([
    //         'pendaftaran_id' => $request->pendaftaran_id,
    //         'judul_laporan' => $request->judul_laporan,
    //         'latar_belakang' => $request->latar_belakang,
    //         'total_biaya' => $request->total_biaya,
    //         'hasil_pelatihan' => $request->hasil_pelatihan,
    //     ]);

    //     return redirect()->route('dashboard.pelatihan.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     $laporan = Pelatihan4Laporan::findOrFail($id);

    //     Storage::disk('public')->delete([
    //         'sertifikat/' . $laporan->sertifikat,
    //         'laporan/' . $laporan->laporan,
    //     ]);

    //     $laporan->delete();

    //     return redirect()->route('dashboard.pelatihan.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    // }
}
