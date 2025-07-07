<table class="table table-hover align-middle mb-0">
    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-kategori">Kategori Jabatan</th>
            <th class="fw-semibold col-jabatan">Jabatan</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="jabatan-table">
        @forelse($jabatans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $jabatans->firstItem() + $loop->index }}</td>
                <td class="col-kategori">{{ $item->kategorijabatan->kategori_jabatan }}</td>
                <td class="col-jabatan">{{ $item->jabatan }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title: 'Edit Jabatan',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.jabatan.update', $item->id) }}',
                        data: {
                            kategorijabatan_id: '{{ $item->kategorijabatan_id }}',
                            jabatan: '{{ $item->jabatan }}'
                        },
                        fields: [
                            {
                                name: 'kategorijabatan_id',
                                label: 'Kategori Jabatan',
                                type: 'select',
                                required: true,
                                col: 12,
                                select2: true,
                                placeholder: 'Cari & Pilih Kategori Jabatan',
                                options: [
                                    @foreach ($kategorijabatans as $kategori)
                                        { value: '{{ $kategori->id }}', label: '{{ $kategori->kategori_jabatan }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'jabatan',
                                label: 'Jabatan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Kepala Dinas, Sekretaris, dll.',
                                col: 12
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.jabatan.destroy', $item->id) }}" method="POST"
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
