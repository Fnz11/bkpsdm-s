<?php

namespace App\Http\Controllers\Umum\AKPK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkpkController extends Controller
{
    public function index()
    {
        return view('MenuUmum.AKPK.homepageAkpk');
    }
}

