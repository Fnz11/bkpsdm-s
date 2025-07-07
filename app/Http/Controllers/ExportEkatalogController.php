<?php

namespace App\Http\Controllers;
use App\Models\Diklat;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportEkatalogController extends Controller implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        return Diklat::select(
            'jenis_diklat',
            'nama_diklat',
            'rumpun',
            'kode_jabatan',
            'penyelenggara',
            'tanggal_pelaksanaan',      
            'tempat_pelaksanaan',       
            'metode_pelaksanaan',       
            'jenis_biaya',              
            'biaya_per_orang',         
            'link_katalog'
        )->get();
    }

    public function headings(): array
    {
        return [
            ['Daftar Ekatalog'],
            [
                'Jenis Diklat',
                'Nama Diklat',
                'Rumpun',
                'Kode Jabatan',
                'Penyelenggara',
                'Tanggal Pelaksanaan',
                'Tempat Pelaksanaan',
                'Metode Pelaksanaan',
                'Jenis Biaya',
                'Biaya Per Orang',
                'Link Katalog'
            ]
        ];
    }

    public function title(): string
    {
        return 'Ekatalog Diklat';
    }

    public function styles(Worksheet $sheet)
    {
        // Set styles untuk judul
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal('center');

        // Set lebar kolom sesuai dengan panjang data
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menyesuaikan tinggi baris untuk setiap baris
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // -1 akan menyesuaikan tinggi baris otomatis
        }
    }

    public function exportekatalog()
    {
        return Excel::download($this, 'ekatalog_diklat.xlsx');
    }
}
