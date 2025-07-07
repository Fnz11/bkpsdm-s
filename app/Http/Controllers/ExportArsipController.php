<?php

namespace App\Http\Controllers;

use App\Models\ArsipBrosur;
use App\Models\Brosur;
use App\Models\UsulanBrosur;
use App\Models\UsulanDiklat;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportArsipController extends Controller implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        return UsulanBrosur::select(
            'nama_penyelenggara',
            'alamat',
            'no_telepon',  // Menggunakan kolom yang benar
            'no_hp',
            'nomor_surat',
            'status_ajuan',
            'created_at'
            )->get()->map(function ($item) {
                return [
                    'nama_penyelenggara' => $item->nama_penyelenggara,
                    'alamat' => $item->alamat,
                    'no_telepon' => $item->no_telepon,
                    'no_hp' => $item->no_hp,
                    'nomor_surat' => $item->nomor_surat,
                    'status_ajuan' => $item->status_ajuan,
                    'created_at' => \Carbon\Carbon::parse($item->tanggal_ajuan)->format('Y-m-d'), // Format hanya tanggal
                ];
            });
    }

    public function headings(): array
    {
        return [
            ['Daftar Arsip Brosur'],
            ['Nama Penyelenggara', 'Alamat', 'No Telepon', 'No HP', 'Nomor Surat','Status Ajuan', 'Tanggal Ajuan']
        ];
    }

    public function title(): string
    {
        return 'Usulan Arsip';
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

    public function exportarsip()
    {
        return Excel::download($this, 'arsip_brosur.xlsx');
    }
}
