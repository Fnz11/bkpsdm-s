<table class="table table-hover align-middle mb-0">

    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-unitkerja">Unit Kerja</th>
            <th class="fw-semibold col-subunit">Sub Unit Kerja</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="subunitkerja-table">
        @forelse($subunitkerjas as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $subunitkerjas->firstItem() + $loop->index }}</td>
                <td class="col-unitkerja">{{ $item->unitkerja->kode_unitkerja }}</td>
                <td class="col-subunit">{{ $item->sub_unitkerja }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title: 'Edit Sub Unit Kerja',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.subunitkerja.update', $item->id) }}',
                        data: {
                            unitkerja_id: '{{ $item->unitkerja_id }}',
                            sub_unitkerja: '{{ $item->sub_unitkerja }}'
                        },
                        fields: [
                            {
                                name: 'unitkerja_id',
                                label: 'Unit Kerja',
                                type: 'select',
                                required: true,
                                select2: true,
                                placeholder: 'Cari & Pilih Sub Unit Kerja',
                                col: 12,
                                options: [
                                    @foreach ($unitkerjas as $unit)
                                        { value: '{{ $unit->id }}', label: '{{ $unit->unitkerja }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'sub_unitkerja',
                                label: 'Sub Unit Kerja',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Dinas Kesehatan',
                                col: 6
                            },
                            {
                                name: 'singkatan',
                                label: 'Singkatan',
                                type: 'text',
                                required: true,
                                placeholder: 'Contoh: Dinkes',
                                col: 6
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.subunitkerja.destroy', $item->id) }}" method="POST"
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
