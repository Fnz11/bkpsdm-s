<table class="table table-hover align-middle mb-0">

    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-kode">Kode</th>
            <th class="fw-semibold col-kategori">Kategori Jabatan</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="kategorijabatan-table">
        @forelse($kategorijabatans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $kategorijabatans->firstItem() + $loop->index }}</td>
                <td class="col-kode">{{ $item->kode_kategorijabatan }}</td>
                <td class="col-kategori">{{ $item->kategori_jabatan }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title: 'Edit Kategori Jabatan',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.kategorijabatan.update', $item->id) }}',
                        data: {
                            kode_kategorijabatan: '{{ $item->kode_kategorijabatan }}',
                            kategori_jabatan: '{{ $item->kategori_jabatan }}',
                        },
                        fields: [
                            {
                                name: 'kode_kategorijabatan',
                                label: 'Kode Kategori Jabatan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: KJ00',
                                col: 12
                            },
                            {
                                name: 'kategori_jabatan',
                                label: 'Kategori Jabatan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Administrator',
                                col: 12
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.kategorijabatan.destroy', $item->id) }}" method="POST"
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
                <td colspan="9" class="text-center py-4">Belum ada nama pelatihan yang diusulkan.</td>
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
