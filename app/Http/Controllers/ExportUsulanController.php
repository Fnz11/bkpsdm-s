<?php

namespace App\Http\Controllers;
use App\Models\UsulanBrosur;
use App\Models\Brosur;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportUsulanController extends Controller implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        return Brosur::select(
            'nama_penyelenggara',
            'alamat',
            'nama_sales',  // Menggunakan kolom yang benar
            'no_hp',
            'no_surat',
            'status',
            'created_at'
            )->get()->map(function ($item) {
                return [
                    'nama_penyelenggara' => $item->nama_penyelenggara,
                    'alamat' => $item->alamat,
                    'no_telepon' => $item->nama_sales,
                    'no_hp' => $item->no_hp,
                    'no_surat' => $item->no_surat,
                    'status' => $item->status,
                    'created_at' => \Carbon\Carbon::parse($item->tanggal_ajuan)->format('Y-m-d'), // Format hanya tanggal
                ];
            });
    }

    public function headings(): array
    {
        return [
            ['Daftar Usulan Brosur'],
            ['Nama Penyelenggara', 'Alamat', 'No Telepon', 'No HP', 'Nomor Surat','Status Ajuan', 'Tanggal Ajuan']
        ];
    }

    public function title(): string
    {
        return 'Usulan Diklat';
    }

    public function styles(Worksheet $sheet)
    {
        // Set styles untuk judul
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');

        // Set lebar kolom sesuai dengan panjang data
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menyesuaikan tinggi baris untuk setiap baris
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // -1 akan menyesuaikan tinggi baris otomatis
        }
    }

    public function exportusulan()
    {
        return Excel::download($this, 'usulan_brosur.xlsx');
    }


    
}
