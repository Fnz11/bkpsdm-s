<table class="table table-hover align-middle mb-0">
    <thead class="bg-light-primary">
        <tr>
            {{-- <th><input type="checkbox" id="select-all"></th> --}}
            <th class="text-center col-no">No</th>
            <th class="col-nama">Nama Pengusul</th>
            <th class="col-uk">Unit Kerja</th>
            <th class="col-nama">Nama Pelatihan</th>
            <th class="col-tanggal">Tanggal Daftar</th>
            <th class="col-surat">Surat OPD</th>
            <th class="col-statusverif">Status Verifikasi</th>
            <th class="col-statuspeserta">Status Peserta</th>
            <th class="col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="pendaftaran-table">
        @forelse ($pendaftarans as $item)
            <tr class="border-bottom">
                {{-- <td><input type="checkbox" class="select-item" name="ids[]" value="{{ $item->id }}"></td> --}}
                <td class="text-center col-no">{{ $pendaftarans->firstItem() + $loop->index }}</td>
                <td class="col-nama">{{ $item->user->refPegawai->name }}</td>
                <td class="col-uk">{{ $item->user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                <td class="col-nama">
                    {{ $item->tersedia?->nama_pelatihan ?? ($item->usulan?->nama_pelatihan ?? '-') }}
                </td>
                <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_pendaftaran)->format('d M Y') }}</td>
                <td class="col-surat">
                    @if ($item->dokumen)
                        <a class="btn btn-outline-primary btn-sm"
                            href="{{ asset('storage/' . $item->dokumen?->file_path) }}" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td class="col-statusverif">
                    <span
                        class="badge bg-{{ $item->status_verifikasi === 'tersimpan'
                            ? 'secondary'
                            : ($item->status_verifikasi === 'tercetak'
                                ? 'warning'
                                : ($item->status_verifikasi === 'terkirim'
                                    ? 'primary'
                                    : ($item->status_verifikasi === 'diterima'
                                        ? 'success'
                                        : 'danger'))) }}">
                        {{ ucfirst($item->status_verifikasi) }}
                    </span>
                </td>
                <td class="col-statuspeserta">
                    <span
                        class="badge bg-{{ $item->status_peserta === 'calon_peserta'
                            ? 'warning'
                            : ($item->status_peserta === 'peserta'
                                ? 'primary'
                                : 'success') }}">
                        {{ ucwords(str_replace('_', ' ', $item->status_peserta)) }}
                    </span>
                </td>
                <td class="col-aksi text-center">
                    <a href="{{ route('dashboard.pelatihan.pendaftaran.show', $item->id) }}"
                        class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('dashboard.pelatihan.pendaftaran.edit', $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">Tidak ada data pendaftaran pelatihan.</td>
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
