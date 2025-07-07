<?php

namespace App\Imports;

use App\Models\Diklat;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class DiklatImport implements ToModel
{
    /**
     * Transform each row into a Diklat model instance.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Convert Excel serial date to standard date format (assuming 1900 date system)
        $tanggalPelaksanaan = $this->convertExcelDate($row[5]);

        return new Diklat([
            'jenis_diklat' => $row[0],
            'nama_diklat' => $row[1],
            'rumpun' => $row[2],
            'kode_jabatan' => $row[3],
            'penyelenggara' => $row[4],
            'tanggal_pelaksanaan' => $tanggalPelaksanaan,
            'tempat_pelaksanaan' => $row[6],
            'metode_pelaksanaan' => $row[7],
            'jenis_biaya' => $row[8],
            'biaya_per_orang' => $row[9],
            'link_katalog' => $row[10] ?? null,
        ]);
    }

    /**
     * Convert Excel serial date to 'YYYY-MM-DD' format.
     *
     * @param mixed $excelDate
     * @return string|null
     */
    private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            return Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($excelDate)->format('Y-m-d');
        }
        return $excelDate; // If already in date format
    }
}
