<table class="table table-hover align-middle mb-0">
    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-nip">NIP</th>
            <th class="fw-semibold col-kode">Kode Pelatihan</th>
            <th class="fw-semibold col-nama">Nama Pelatihan</th>
            <th class="fw-semibold col-jenis">Jenis Pelatihan</th>
            <th class="fw-semibold col-status">Status</th>
            <th class="fw-semibold col-keterangan">Keterangan</th>
            <th class="fw-semibold col-tanggal">Tanggal Usulan</th>
            <th class="fw-semibold col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="namapelatihan-table">
        @forelse($namapelatihans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $namapelatihans->firstItem() + $loop->index }}</td>
                <td class="col-nip">{{ $item->nip }}</td>
                <td class="col-kode">{{ $item->kode_namapelatihan }}</td>
                <td class="col-nama">{{ $item->nama_pelatihan }}</td>
                <td class="col-jenis">{{ $item->jenispelatihan->jenis_pelatihan }}</td>
                <td class="col-status text-center">
                    @if ($item->status === 'diterima')
                        <span class="badge bg-success">Diterima</span>
                    @elseif ($item->status === 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-info text-dark">Proses</span>
                    @endif
                </td>
                <td class="col-keterangan">{{ $item->keterangan ?? '-' }}</td>
                <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                    title: 'Edit Nama Pelatihan',
                    method: 'PUT',
                    icon: 'bi-pencil-square',
                    action: '{{ route('dashboard.pelatihan.nomenklatur.update', $item->id) }}',
                    data: {
                        kode_namapelatihan: '{{ $item->kode_namapelatihan }}',
                        nama_pelatihan: '{{ $item->nama_pelatihan }}',
                        jenispelatihan_id: '{{ $item->jenispelatihan_id }}',
                        status: '{{ $item->status }}',
                        keterangan: '{{ $item->keterangan ?? '' }}'
                    },
                    fields: [
                        { name: 'kode_namapelatihan', label: 'Kode Pelatihan', type: 'text', required: true },
                        { name: 'nama_pelatihan', label: 'Nama Pelatihan', type: 'text', required: true },
                        {
                            name: 'jenispelatihan_id', label: 'Jenis Pelatihan', type: 'select', required: true, col: 6,
                            select2: true,
                            options: [
                                { value: '', label: 'Pilih Jenis Pelatihan', disabled: true },
                                @foreach ($jenispelatihans as $jenis)
                                    { value: '{{ $jenis->id }}', label: '{{ $jenis->jenis_pelatihan }}' }, @endforeach
                            ]
                        },
                        {
                            name: 'status', label: 'Status', type: 'select', required: true, col: 6,
                            options: [
                                { value: '', label: 'Pilih Status', disabled: true },
                                { value: 'proses', label: 'Proses' },
                                { value: 'diterima', label: 'Diterima' },
                                { value: 'ditolak', label: 'Ditolak' }
                            ]
                        },
                        { name: 'keterangan', label: 'Keterangan', type: 'textarea', required: false }
                    ]
                })">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('dashboard.pelatihan.nomenklatur.destroy', $item->id) }}" method="POST"
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
