<table class="table table-hover align-middle mb-0">

    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-kode">Kode</th>
            <th class="fw-semibold col-pelaksanaan">Pelaksanaan Pelatihan</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="pelaksanaanpelatihan-table">
        @forelse($pelaksanaanpelatihans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $pelaksanaanpelatihans->firstItem() + $loop->index }}</td>
                <td class="col-kode">{{ $item->kode_pelaksanaanpelatihan }}</td>
                <td class="col-pelaksanaan">{{ $item->pelaksanaan_pelatihan }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title: 'Edit Pelaksanaan Pelatihan',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.pelaksanaanpelatihan.update', $item->id) }}',
                        data: {
                            kode_pelaksanaanpelatihan: '{{ $item->kode_pelaksanaanpelatihan }}',
                            pelaksanaan_pelatihan: '{{ $item->pelaksanaan_pelatihan }}',
                        },
                        fields: [
                            {
                                name: 'kode_pelaksanaanpelatihan',
                                label: 'Kode Pelaksanaan Pelatihan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: PP00',
                                col: 12
                            },
                            {
                                name: 'pelaksanaan_pelatihan',
                                label: 'Pelaksanaan Pelatihan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Penyelenggaraan',
                                col: 12
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.pelaksanaanpelatihan.destroy', $item->id) }}" method="POST"
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
