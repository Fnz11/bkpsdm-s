<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;
use App\Models\Brosur_2_masuk;


use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
    // Hitung jumlah data di tabel usulan_diklat
        $draftKatalog = Brosur_2_masuk::count();

    // Hitung jumlah data di tabel usulan_laporan_diklat
        $draftLaporan = Brosur_2_masuk::count();

    return view('dashboard', compact('draftKatalog', 'draftLaporan'));
    }

}

