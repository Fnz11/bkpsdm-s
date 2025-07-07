<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsulanDiklatImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ImportUsulanController extends Controller
{
    public function importUsulanDiklat(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new UsulanDiklatImport, $request->file('file'));
            return Redirect::route('brosur.usulan')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }
}
