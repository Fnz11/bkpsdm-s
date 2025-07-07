<?php

namespace App\Imports;

use App\Models\Arsip;
use App\Models\ArsipBrosur;
use Maatwebsite\Excel\Concerns\ToModel;

class ArsipImport implements ToModel
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ArsipBrosur([
            // Map each column in the Excel row to a model attribute
            'nama_penyelenggara' => $row[0],
            'alamat' => $row[1],
            'no_telepon' => $row[2],
            'no_hp' => $row[3],
            'nomor_surat' => $row[4],
            'status_ajuan' => $row[5],
            'tanggal_ajuan' => $row[6],
            // Add other columns as needed
        ]);
    }
}
