<table class="table table-hover align-middle mb-0">
    <thead class="bg-light-primary">
        <tr>
            <th class="text-center col-no">No</th>
            <th class="col-nama">Nama</th>
            <th class="col-uk">Unit Kerja</th>
            <th class="col-nama">Pelatihan</th>
            <th class="col-judul">Judul Laporan</th>
            <th class="col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="alumni-table">
        @forelse ($alumnis as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $alumnis->firstItem() + $loop->index }}</td>
                <td class="col-nama">{{ $item->user->refPegawai->name }}</td>
                <td class="col-uk">{{ $item->user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                <td class="col-nama">
                    {{ $item->tersedia?->nama_pelatihan ?? ($item->usulan?->nama_pelatihan ?? '-') }}
                </td>
                <td class="col-judul">{{ $item->laporan?->judul_laporan }}</td>
                <td class="col-aksi text-center">
                    <a href="{{ route('dashboard.pelatihan.alumni.show', $item->id) }}"
                        class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">Tidak ada data alumni pelatihan.</td>
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
