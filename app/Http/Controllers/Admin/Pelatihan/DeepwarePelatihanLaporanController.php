<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\PelatihanLaporan;
use Illuminate\Http\Request;

class DeepwarePelatihanLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all pelatihan laporan data
        $laporan = PelatihanLaporan::with([
            'registrasi.user.userPivot.golongan',
            'registrasi.user.userPivot.unitKerja',
            'registrasi.user.userPivot.jabatan',
            'registrasi.pelatihan'
        ])->get();

        // Return the view with pelatihan laporan data
        return view('dashboard.pelatihan.laporan-pelatihan', compact('laporan'));
    }

    public function showVerifikasiLaporan(PelatihanLaporan $laporan)
    {
        // Show the verification page for the specified pelatihan
        return view('dashboard.pelatihan.verifikasi-usul-pelatihan', compact('laporan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PelatihanLaporan $pelatihanLaporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PelatihanLaporan $pelatihanLaporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PelatihanLaporan $pelatihanLaporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PelatihanLaporan $pelatihanLaporan)
    {
        //
    }
}
