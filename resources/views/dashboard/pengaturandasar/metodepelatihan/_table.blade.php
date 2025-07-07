<table class="table table-hover align-middle mb-0">

    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-kode">Kode</th>
            <th class="fw-semibold col-metode">Metode Pelatihan</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="metodepelatihan-table">
        @forelse($metodepelatihans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $metodepelatihans->firstItem() + $loop->index }}</td>
                <td class="col-kode">{{ $item->kode_metodepelatihan }}</td>
                <td class="col-metode">{{ $item->metode_pelatihan }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title: 'Edit Metode Pelatihan',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.metodepelatihan.update', $item->id) }}',
                        data: {
                            kode_metodepelatihan: '{{ $item->kode_metodepelatihan }}',
                            metode_pelatihan: '{{ $item->metode_pelatihan }}',
                        },
                        fields: [
                            {
                                name: 'kode_metodepelatihan',
                                label: 'Kode Metode Pelatihan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: MP00',
                                col: 12
                            },
                            {
                                name: 'metode_pelatihan',
                                label: 'Metode Pelatihan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Online',
                                col: 12
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.metodepelatihan.destroy', $item->id) }}" method="POST"
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
