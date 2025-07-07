<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanDasarController extends Controller
{
    /**
     * Display the basic settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('layouts.pelatihan.pengaturandasar');
    }
}
