<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DiklatImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ImportDiklatController extends Controller
{
    public function importDiklat(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new DiklatImport, $request->file('file'));
            return Redirect::route('ekatalog.diklat')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }
}
