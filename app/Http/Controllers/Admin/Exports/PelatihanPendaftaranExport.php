<?php

namespace App\Http\Controllers\Admin\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelatihanPendaftaranExport implements FromCollection, WithHeadings
{
    protected $pendaftarans;
    protected $columns;
    protected $includeHeader;

    public function __construct($pendaftarans, $columns, $includeHeader)
    {
        $this->pendaftarans = $pendaftarans;
        $this->columns = $columns;
        $this->includeHeader = $includeHeader;
    }

    public function collection()
    {
        return $this->pendaftarans->map(function ($item) {
            $row = [];

            if (in_array('nip', $this->columns)) {
                $row['NIP'] = $item->user->nip;
            }

            if (in_array('nama', $this->columns)) {
                $row['Nama'] = $item->user->refPegawai->name;
            }

            if (in_array('pelatihan', $this->columns)) {
                $row['Nama Pelatihan'] = $item->tersedia?->nama_pelatihan ?? $item->usulan?->nama_pelatihan;
            }

            if (in_array('unit_kerja', $this->columns)) {
                $row['Unit Kerja'] = $item->user->latestUserPivot->unitKerja->unitkerja->unitkerja;
            }

            if (in_array('jenis', $this->columns)) {
                $row['Jenis Usulan'] = $item->tersedia ? 'Pelatihan Umum' : 'Pelatihan Khusus';
            }

            if (in_array('tanggal_daftar', $this->columns)) {
                $row['Tanggal Daftar'] = \Carbon\Carbon::parse($item->tanggal_pendaftaran)->format('d-m-Y');
            }

            return $row;
        });
    }

    public function headings(): array
    {
        if (!$this->includeHeader) return [];

        $headings = [];

        if (in_array('nip', $this->columns)) {
            $headings[] = 'NIP';
        }

        if (in_array('nama', $this->columns)) {
            $headings[] = 'Nama';
        }

        if (in_array('pelatihan', $this->columns)) {
            $headings[] = 'Nama Pelatihan';
        }

        if (in_array('unit_kerja', $this->columns)) {
            $headings[] = 'Unit Kerja';
        }

        if (in_array('jenis', $this->columns)) {
            $headings[] = 'Jenis Usulan';
        }

        if (in_array('tanggal_daftar', $this->columns)) {
            $headings[] = 'Tanggal Daftar';
        }

        return $headings;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\n",
            'use_bom' => true,
            'include_separator_line' => false,
            'excel_compatibility' => false,
            'output_encoding' => 'UTF-8',
        ];
    }
}
