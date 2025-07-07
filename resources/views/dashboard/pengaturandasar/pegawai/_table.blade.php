<table class="table table-hover align-middle mb-0">

    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-nip">NIP</th>
            <th class="fw-semibold col-nama">Nama</th>
            <th class="fw-semibold col-jenis">Jenis ASN</th>
            <th class="fw-semibold col-jabatan">Jabatan</th>
            <th class="fw-semibold col-golongan">Golongan</th>
            <th class="fw-semibold col-sub">Sub Unit Kerja</th>
            <th class="fw-semibold col-unit">Unit Kerja</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="pegawai-table">
        @forelse($pegawais as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $pegawais->firstItem() + $loop->index }}</td>
                <td class="col-nip">{{ $item->nip }}</td>
                <td class="col-nama">{{ $item->user?->refPegawai?->name }}</td>
                <td class="col-jenis">{{ $item->user?->latestUserPivot?->golongan?->jenisasn?->jenis_asn }}</td>
                <td class="col-jabatan">
                    {{ $item->user?->latestUserPivot?->jabatan?->jabatan ?? '-' }}
                </td>
                <td class="col-golongan">
                    {{ $item->user?->latestUserPivot?->golongan?->pangkat_golongan ?? '-' }}
                </td>
                <td class="col-sub">
                    {{ $item->user?->latestUserPivot?->unitKerja?->sub_unitkerja ?? '-' }}
                </td>
                <td class="col-unit">
                    {{ $item->user?->latestUserPivot?->unitKerja?->unitkerja?->unitkerja ?? '-' }}
                </td>
                <td class="col-aksi text-center">
                    <a href="{{ route('dashboard.pelatihan.pegawai.edit', $item->id) }}"
                        class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('dashboard.pelatihan.pegawai.destroy', $item->id) }}" method="POST"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                            data-form-id="form-{{ $item->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">Belum ada pegawai.</td>
            </tr>
        @endforelse
    </tbody>
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
