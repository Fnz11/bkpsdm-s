<?php

namespace App\Http\Controllers\Admin\Exports;

use App\Models\Pelatihan3Pendaftaran;
use App\Models\ref_unitkerjas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapitulasiPendaftaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;
    protected $startDate;
    protected $endDate;
    protected $jenisRekap;
    protected $includeHeader;
    protected $columns;
    protected $fileFormat;

    public function __construct(
        $search = null,
        $startDate = null,
        $endDate = null,
        $jenisRekap = 'pelatihan',
        $includeHeader = true,
        $columns = ['no', 'nama', 'jumlah'],
        $fileFormat = 'xlsx'
    ) {
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->jenisRekap = $jenisRekap;
        $this->includeHeader = $includeHeader;
        $this->columns = $columns;
        $this->fileFormat = $fileFormat;
    }

    public function collection()
    {
        if ($this->jenisRekap === 'pelatihan') {
            return $this->getDataPelatihan();
        } else {
            return $this->getDataOPD();
        }
    }

    public function headings(): array
    {
        if (!$this->includeHeader) {
            return [];
        }

        $headings = [];

        // Sesuaikan urutan kolom berdasarkan pilihan user
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'no':
                    $headings[] = 'No';
                    break;
                case 'nama':
                    $headings[] = $this->jenisRekap === 'pelatihan' ? 'Nama Pelatihan' : 'Nama OPD';
                    break;
                case 'jumlah':
                    $headings[] = 'Jumlah Pendaftar';
                    break;
            }
        }

        return $headings;
    }

    public function map($row): array
    {
        $data = [];
        $index = $this->collection()->search($row) + 1;

        // Sesuaikan urutan kolom berdasarkan pilihan user
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'no':
                    $data[] = $index;
                    break;
                case 'nama':
                    $data[] = $this->jenisRekap === 'pelatihan' ? $row->nama : $row->opd;
                    break;
                case 'jumlah':
                    $data[] = $row->jumlah_usulan;
                    break;
            }
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function getDataPelatihan()
    {
        $query = Pelatihan3Pendaftaran::selectRaw('
                COALESCE(tersedia.nama_pelatihan, usulan.nama_pelatihan) as nama,
                COUNT(*) as jumlah_usulan
            ')
            ->leftJoin('pelatihan_2_tersedias as tersedia', 'tersedia.id', '=', 'pelatihan_3_pendaftarans.tersedia_id')
            ->leftJoin('pelatihan_2_usulans as usulan', 'usulan.id', '=', 'pelatihan_3_pendaftarans.usulan_id')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('tersedia.nama_pelatihan', 'like', "%{$this->search}%")
                        ->orWhere('usulan.nama_pelatihan', 'like', "%{$this->search}%");
                });
            })
            ->when($this->startDate && $this->endDate, function ($q) {
                $q->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$this->startDate, $this->endDate]);
            })
            ->groupBy('nama')
            ->orderBy('jumlah_usulan', 'desc');

        return $query->get();
    }

    private function getDataOPD()
    {
        $query = ref_unitkerjas::select([
            'ref_unitkerjas.id',
            'ref_unitkerjas.unitkerja as opd',
            DB::raw('COUNT(pelatihan_3_pendaftarans.id) as jumlah_usulan')
        ])
            ->leftJoin('ref_subunitkerjas', 'ref_subunitkerjas.unitkerja_id', '=', 'ref_unitkerjas.id')
            ->leftJoin('user_pivot', 'user_pivot.id_unitkerja', '=', 'ref_subunitkerjas.id')
            ->leftJoin('users', 'users.nip', '=', 'user_pivot.nip')
            ->leftJoin('pelatihan_3_pendaftarans', function ($join) {
                $join->on('pelatihan_3_pendaftarans.user_nip', '=', 'users.nip');

                if ($this->startDate && $this->endDate) {
                    $join->whereBetween('pelatihan_3_pendaftarans.tanggal_pendaftaran', [$this->startDate, $this->endDate]);
                }
            })
            ->when($this->search, function ($q) {
                $q->where('ref_unitkerjas.unitkerja', 'like', "%{$this->search}%");
            })
            ->groupBy('ref_unitkerjas.id', 'ref_unitkerjas.unitkerja')
            ->orderBy('ref_unitkerjas.unitkerja');

        return $query->get();
    }
}
