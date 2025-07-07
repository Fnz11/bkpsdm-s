<table class="table table-hover align-middle mb-0">
    <thead class="bg-light-primary">
        <tr>
            <th class="text-center col-no">No</th>
            <th>Nama</th>
            <th>Unit Kerja</th>
            <th>Sub Unit Kerja</th>
            <th>Kategori Jabatan</th>
            <th>Jabatan</th>
            <th>Pangkat</th>
            <th>Golongan</th>
            <th>Jenis ASN</th>
            <th>Tgl Mulai</th>
            <th>Tgl Akhir</th>
        </tr>
    </thead>
    <tbody id="aktif-table">
        @forelse($activePivots as $pivot)
            <tr class="border-bottom">
                <td class="text-center col-no">
                    {{ ($activePivots->currentPage() - 1) * $activePivots->perPage() + $loop->iteration }}
                </td>
                <td>{{ $pivot->user?->refPegawai?->name }}</td>
                <td>{{ $pivot->unitKerja?->unitkerja?->unitkerja }}</td>
                <td>{{ $pivot->unitKerja?->sub_unitkerja }}</td>
                <td>{{ $pivot->jabatan?->kategorijabatan?->kategori_jabatan }}</td>
                <td>{{ $pivot->jabatan?->jabatan }}</td>
                <td>{{ $pivot->golongan?->pangkat }}</td>
                <td>{{ $pivot->golongan?->golongan }}</td>
                <td>{{ $pivot->golongan?->jenisasn?->jenis_asn }}</td>
                <td>{{ \Carbon\Carbon::parse($pivot->tgl_mulai)->translatedFormat('d M Y') }}</td>
                <td>
                    {{ $pivot->tgl_akhir ? \Carbon\Carbon::parse($pivot->tgl_akhir)->translatedFormat('d M Y') : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center py-4">Tidak ada data pivot aktif ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr id="loading-spinner-aktif" class="d-none">
            <td colspan="12" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
