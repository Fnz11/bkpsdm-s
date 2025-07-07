<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PelatihanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ImportPelatihanController extends Controller
{
    public function importPelatihan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new PelatihanImport, $request->file('file'));
            return Redirect::route('ekatalog.pelatihan')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }
}
