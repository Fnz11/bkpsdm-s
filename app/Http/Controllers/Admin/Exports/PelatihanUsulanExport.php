<?php

namespace App\Http\Controllers\Admin\Exports;

use App\Models\Pelatihan2Tersedia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PelatihanUsulanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $pelatihans;
    protected $columns;
    protected $includeHeader;

    public function __construct($pelatihans, $columns = [], $includeHeader = true)
    {
        $this->pelatihans = $pelatihans;
        $this->columns = $columns ?: [
            'pengusul',
            'nama',
            'jenis',
            'metode',
            'pelaksanaan',
            'penyelenggara',
            'tempat',
            'tanggal',
            'kuota',
            'estimasi',
            'realisasi'
        ];
        $this->includeHeader = $includeHeader;
    }

    public function collection()
    {
        return $this->pelatihans;
    }

    public function headings(): array
    {
        if (!$this->includeHeader) {
            return [];
        }

        $headings = [];
        $columnLabels = [
            'pengusul' => 'Nama Pengusul',
            'nama' => 'Nama Pelatihan',
            'jenis' => 'Jenis Pelatihan',
            'metode' => 'Metode Pelatihan',
            'pelaksanaan' => 'Pelaksanaan',
            'penyelenggara' => 'Penyelenggara',
            'tempat' => 'Tempat',
            'tanggal' => 'Tanggal Pelatihan',
            'kuota' => 'Kuota',
            'estimasi' => 'Estimasi Biaya',
            'realisasi' => 'Realisasi Biaya',
        ];

        foreach ($this->columns as $column) {
            if (isset($columnLabels[$column])) {
                $headings[] = $columnLabels[$column];
            }
        }

        return $headings;
    }

    public function map($pelatihan): array
    {
        $row = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'pengusul':
                    $row[] = $pelatihan->user->refPegawai->name ?? '-';
                    break;
                case 'nama':
                    $row[] = $pelatihan->nama_pelatihan;
                    break;
                case 'jenis':
                    $row[] = $pelatihan->jenispelatihan->jenis_pelatihan ?? '-';
                    break;
                case 'metode':
                    $row[] = $pelatihan->metodepelatihan->metode_pelatihan ?? '-';
                    break;
                case 'pelaksanaan':
                    $row[] = $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-';
                    break;
                case 'penyelenggara':
                    $row[] = $pelatihan->penyelenggara_pelatihan;
                    break;
                case 'tempat':
                    $row[] = $pelatihan->tempat_pelatihan;
                    break;
                case 'tanggal':
                    $row[] = \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d/m/Y') . ' - ' .
                        \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d/m/Y');
                    break;
                case 'kuota':
                    $row[] = $pelatihan->kuota;
                    break;
                case 'estimasi':
                    $row[] = 'Rp' . number_format($pelatihan->estimasi_biaya, 0, ',', '.');
                    break;
                case 'realisasi':
                    $row[] = 'Rp' . number_format($pelatihan->realisasi_biaya, 0, ',', '.');
                    break;
                default:
                    $row[] = '';
                    break;
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9D9D9']
                ]
            ],
            // Set alignment for all cells
            'A:Z' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            // Format number columns
            'H' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'I' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
        ];
    }
}
