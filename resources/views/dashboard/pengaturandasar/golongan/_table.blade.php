<table class="table table-hover align-middle mb-0">
    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-kode">Kode</th>
            <th class="fw-semibold col-jenis">Jenis ASN</th>
            <th class="fw-semibold col-golongan">Golongan</th>
            <th class="fw-semibold col-pangkat">Pangkat</th>
            <th class="fw-semibold col-pangkat-golongan">Pangkat Golongan</th>
            {{-- <th class="fw-semibold col-dibuat">Dibuat</th>
        <th class="fw-semibold col-diperbarui">Diperbarui</th> --}}
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="golongan-table">
        @forelse($golongans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $golongans->firstItem() + $loop->index }}</td>
                <td class="col-kode">{{ $item->kode_golongan }}</td>
                <td class="col-jenis">{{ $item->jenisasn->jenis_asn }}</td>
                <td class="col-golongan">{{ $item->golongan }}</td>
                <td class="col-pangkat">{{ $item->pangkat }}</td>
                <td class="col-pangkat-golongan">{{ $item->pangkat_golongan }}</td>
                {{-- <td class="col-dibuat">{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
            <td class="col-diperbarui">{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') ?? '-' }}</td> --}}
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning "
                        onclick="openDynamicModal({
                        title: 'Edit Golongan',
                        method: 'PUT',
                        icon: 'bi-pencil-square',
                        action: '{{ route('dashboard.pelatihan.golongan.update', $item->id) }}',
                        data: {
                            kode_golongan: '{{ $item->kode_golongan }}',
                            jenisasn_id: '{{ $item->jenisasn_id }}',
                            golongan: '{{ $item->golongan }}',
                            pangkat: '{{ $item->pangkat }}',
                            pangkat_golongan: '{{ $item->pangkat_golongan }}'
                        },
                        fields: [
                            {
                                name: 'kode_golongan',
                                label: 'Kode Golongan',
                                type: 'text',
                                required: true,
                                col: 6,
                                placeholder: 'Contoh: III/a'
                            },
                            {
                                name: 'jenisasn_id',
                                label: 'Jenis ASN',
                                type: 'select',
                                required: true,
                                select2: true,
                                placeholder: 'Cari & Pilih Jenis ASN',
                                col: 6,
                                options: [
                                    @foreach ($jenisasns as $asn)
                                        { value: '{{ $asn->id }}', label: '{{ $asn->jenis_asn }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'golongan',
                                label: 'Golongan',
                                type: 'text',
                                required: true,
                                col: 6,
                                placeholder: 'Contoh: III/a'
                            },
                            {
                                name: 'pangkat',
                                label: 'Pangkat',
                                type: 'text',
                                required: true,
                                col: 6,
                                placeholder: 'Contoh: Penata Muda'
                            },
                            {
                                name: 'pangkat_golongan',
                                label: 'Pangkat Golongan',
                                type: 'text',
                                required: true,
                                col: 12,
                                placeholder: 'Contoh: Penata Muda (III/a)'
                            }
                        ]
                    })">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.golongan.destroy', $item->id) }}" method="POST"
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
