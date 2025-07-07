<?php

namespace App\Http\Controllers\Admin\Exports;

use App\Models\UserPivot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserPivotExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pivots;
    protected $columns;
    protected $includeHeader;

    public function __construct($pivots, $columns = [], $includeHeader = true)
    {
        $this->pivots = $pivots;
        $this->columns = $columns ?: array_keys($this->getAvailableColumns());
        $this->includeHeader = $includeHeader;
    }

    public function collection()
    {
        return $this->pivots;
    }

    public function headings(): array
    {
        if (!$this->includeHeader) {
            return [];
        }

        $headings = [];
        $availableColumns = $this->getAvailableColumns();

        foreach ($availableColumns as $column => $title) {
            if (in_array($column, $this->columns)) {
                $headings[] = $title;
            }
        }

        return $headings;
    }

    public function map($pivot): array
    {
        $row = [];
        $availableColumns = $this->getAvailableColumns();

        foreach ($availableColumns as $column => $title) {
            if (in_array($column, $this->columns)) {
                $row[] = $this->getColumnValue($column, $pivot);
            }
        }

        return $row;
    }

    protected function getColumnValue($column, $pivot)
    {
        switch ($column) {
            case 'no':
                return $this->pivots->search($pivot) + 1;
            case 'nip':
                return $pivot->nip ?? '-';
            case 'nama':
                return $pivot->user?->refPegawai?->name ?? '-';
            case 'unit_kerja':
                return $pivot->unitKerja?->unitkerja?->unitkerja ?? '-';
            case 'sub_unit':
                return $pivot->unitKerja?->sub_unitkerja ?? '-';
            case 'kategori_jabatan':
                return $pivot->jabatan?->kategorijabatan?->kategori_jabatan ?? '-';
            case 'jabatan':
                return $pivot->jabatan?->jabatan ?? '-';
            case 'pangkat':
                return $pivot->golongan?->pangkat ?? '-';
            case 'golongan':
                return $pivot->golongan?->golongan ?? '-';
            case 'jenis_asn':
                return $pivot->golongan?->jenisasn?->jenis_asn ?? '-';
            case 'tgl_mulai':
                return $pivot->tgl_mulai ? \Carbon\Carbon::parse($pivot->tgl_mulai)->format('d/m/Y') : '-';
            case 'tgl_akhir':
                return $pivot->tgl_akhir ? \Carbon\Carbon::parse($pivot->tgl_akhir)->format('d/m/Y') : '-';
            default:
                return '';
        }
    }

    protected function getAvailableColumns()
    {
        $columns = [
            'no' => 'No',
            'nip' => 'NIP',
            'nama' => 'Nama',
            'unit_kerja' => 'Unit Kerja',
            'sub_unit' => 'Sub Unit Kerja',
            'kategori_jabatan' => 'Kategori Jabatan',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'golongan' => 'Golongan',
            'jenis_asn' => 'Jenis ASN',
            'tgl_mulai' => 'Tanggal Mulai',
            'tgl_akhir' => 'Tanggal Akhir',
        ];

        return $columns;
    }
}
