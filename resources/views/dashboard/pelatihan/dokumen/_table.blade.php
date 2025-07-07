<table class="table table-hover align-middle mb-0">
    <thead>
        <tr>
            <th class="col-no">No</th>
            <th class="col-opd">OPD</th>
            <th class="col-nama">Nama Dokumen</th>
            <th class="col-file">File</th>
            <th class="col-upload">Tanggal Upload</th>
            <th class="col-keterangan">Keterangan</th>
            <th class="col-status">Status</th>
            <th class="col-aksi">Aksi</th>
        </tr>
    </thead>
    <tbody id="dokumen-table">
        @forelse ($dokumens as $i => $dokumen)
            <tr>
                <td class="col-no">{{ $loop->iteration }}</td>
                <td class="col-opd">{{ $dokumen->admin->latestUserPivot->unitKerja->unitkerja->unitkerja }}</td>
                <td class="col-nama">{{ $dokumen->nama_dokumen }}</td>
                <td class="col-file">
                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">
                        <i class="bi bi-file-earmark-text"></i> Lihat
                    </a>
                </td>
                <td class="col-upload">{{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->translatedFormat('d M Y') }}
                </td>
                <td class="col-keterangan">{{ $dokumen->keterangan ?? '-' }}</td>
                <td class="col-status">
                    <span
                        class="badge bg-{{ $dokumen->status == 'diterima' ? 'success' : ($dokumen->status == 'ditolak' ? 'danger' : 'warning') }}">
                        {{ ucfirst($dokumen->status) }}
                    </span>
                </td>
                <td class="col-aksi">
                    <a href="{{ route('dashboard.pelatihan.dokumen.show', $dokumen->id) }}"
                        class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                    @if (auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('dashboard.pelatihan.dokumen.edit', $dokumen->id) }}"
                            class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada dokumen ditemukan.</td>
            </tr>
        @endforelse
    </tbody>

    <!-- Pagination -->
    <tfoot>
        {{-- Spinner berada di sini --}}
        <tr id="loading-spinner" class="d-none">
            <td colspan="9" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
