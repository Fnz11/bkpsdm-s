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
            <th>Status</th>
            <th class="text-center col-aksi">Aksi</th>
        </tr>
    </thead>
    <tbody id="usulan-table">
        @forelse($proposedPivots as $pivot)
            <tr class="border-bottom">
                <td class="text-center col-no">
                    {{ ($proposedPivots->currentPage() - 1) * $proposedPivots->perPage() + $loop->iteration }}
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
                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                </td>
                <td class="text-center col-aksi">
                    <form action="{{ route('dashboard.pelatihan.user.approve', $pivot->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('dashboard.pelatihan.user.reject', $pivot->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center py-4">Tidak ada usulan perubahan ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr id="loading-spinner-usulan" class="d-none">
            <td colspan="12" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
