<?php

namespace App\Imports;

use App\Models\Pelatihan;
use Maatwebsite\Excel\Concerns\ToModel;


class PelatihanImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new pelatihan([
            'jenis_pelatihan' => $row[0],
            'nama_lembaga' => $row[1],
            // Map additional columns here if needed
        ]);
    }
}
