<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ArsipImport;
use Maatwebsite\Excel\Facades\Excel;


class ImportArsipController extends Controller
{

    public function importArsip(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ArsipImport, $request->file('file'));
            return redirect()->route('brosur.arsip')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }

}