<?php

namespace App\Http\Controllers\Admin\Exports;

use App\Models\Pelatihan4Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PelatihanLaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $laporans;
    protected $columns;
    protected $includeHeader;

    public function __construct($laporans, $columns, $includeHeader)
    {
        $this->laporans = $laporans;
        $this->columns = $columns;
        $this->includeHeader = $includeHeader;
    }

    public function collection()
    {
        return $this->laporans;
    }

    public function headings(): array
    {
        if (!$this->includeHeader) {
            return [];
        }

        $headings = [];

        if (in_array('judul', $this->columns)) {
            $headings[] = 'Judul Laporan';
        }
        if (in_array('latar_belakang', $this->columns)) {
            $headings[] = 'Latar Belakang';
        }
        if (in_array('total_biaya', $this->columns)) {
            $headings[] = 'Total Biaya';
        }
        if (in_array('hasil_pelatihan', $this->columns)) {
            $headings[] = 'Hasil Pelatihan';
        }
        if (in_array('created_at', $this->columns)) {
            $headings[] = 'Tanggal Laporan';
        }

        return $headings;
    }

    public function map($laporan): array
    {
        $row = [];

        if (in_array('judul', $this->columns)) {
            $row[] = $laporan->judul_laporan;
        }
        if (in_array('latar_belakang', $this->columns)) {
            $row[] = $laporan->latar_belakang;
        }
        if (in_array('total_biaya', $this->columns)) {
            $row[] = $laporan->total_biaya;
        }
        if (in_array('hasil_pelatihan', $this->columns)) {
            $row[] = ucfirst($laporan->hasil_pelatihan);
        }
        if (in_array('created_at', $this->columns)) {
            $row[] = $laporan->created_at->format('d/m/Y');
        }

        return $row;
    }
}
