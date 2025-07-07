<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeepwareKepegawaianController extends Controller
{
    public function index()
    {
        return view('dashboard.pelatihan.kepegawaian.index');
    }

    public function create()
    {
        return view('dashboard.pelatihan.kepegawaian.create');
    }

    public function edit($id)
    {
        return view('dashboard.pelatihan.kepegawaian.edit', compact('id'));
    }
}
