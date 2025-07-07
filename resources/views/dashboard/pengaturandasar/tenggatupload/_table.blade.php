<table class="table table-hover align-middle mb-0">
    <thead>
        <tr class="bg-light-primary">
            <th class="col-no text-center">No</th>
            <th class="col-tahun">Tahun</th>
            <th class="col-jenis">Jenis Deadline</th>
            <th class="col-mulai">Mulai</th>
            <th class="col-deadline">Deadline</th>
            <th class="col-keterangan">Keterangan</th>
            <th class="col-aksi text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="tenggat-table">
        @forelse($tenggats as $item)
            <tr>
                <td class="text-center col-no">{{ $tenggats->firstItem() + $loop->index }}</td>
                <td class="col-tahun">{{ $item->tahun }}</td>
                <td class="col-jenis">{{ ucfirst(str_replace('_', ' ', $item->jenis_deadline)) }}</td>
                <td class="col-mulai">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') ?: '-' }}</td>
                <td class="col-deadline">{{ \Carbon\Carbon::parse($item->tanggal_deadline)->format('d M Y') }}</td>
                <td class="col-keterangan">{{ $item->keterangan }}</td>
                <td class="col-aksi text-center">
                    <button class="btn btn-sm btn-warning"
                        onclick="openDynamicModal({
                        title:'Edit Tenggat',
                        method:'PUT',
                        icon:'bi-pencil-square',
                        action:'{{ route('dashboard.pelatihan.tenggat.update', $item->id) }}',
                        data:{
                            tahun:'{{ $item->tahun }}',
                            jenis_deadline:'{{ $item->jenis_deadline }}',
                            tanggal_mulai:'{{ $item->tanggal_mulai }}',
                            tanggal_deadline:'{{ $item->tanggal_deadline }}',
                            tersedia_id:'{{ $item->tersedia_id }}',
                            pendaftaran_id:'{{ $item->pendaftaran_id }}',
                            keterangan:'{{ $item->keterangan }}'
                        },
                        fields: [
                            {
                                name: 'tahun',
                                type: 'number',
                                label: 'Tahun',
                                required: true,
                                placeholder: 'Contoh: 2025',
                                col: 6
                            },
                            {
                                name: 'jenis_deadline',
                                type: 'select',
                                label: 'Jenis Deadline',
                                required: true,
                                col: 6,
                                options: [
                                    { value: 'laporan_user', label: 'Laporan User' },
                                    { value: 'dokumen_admin', label: 'Dokumen Admin' }
                                ]
                            },
                            {
                                name: 'tanggal_mulai',
                                type: 'date',
                                label: 'Tanggal Mulai',
                                col: 6
                            },
                            {
                                name: 'tanggal_deadline',
                                type: 'date',
                                label: 'Tanggal Deadline',
                                required: true,
                                col: 6
                            },
                            {
                                name: 'tersedia_id',
                                type: 'select',
                                label: 'Pelatihan Tersedia',
                                col: 6,
                                select2: true,
                                options: [
                                    @foreach (\App\Models\Pelatihan2Tersedia::orderBy('nama_pelatihan')->get() as $lat)
                                        { value: '{{ $lat->id }}', label: '{{ $lat->nama_pelatihan }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'pendaftaran_id',
                                type: 'select',
                                label: 'Pendaftaran (Usulan)',
                                col: 6,
                                select2: true,
                                options: [
                                    @foreach (\App\Models\Pelatihan3Pendaftaran::orderBy('id')->get() as $daftar)
                                        { value: '{{ $daftar->id }}', label: 'Pendaftaran #{{ $daftar->id }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'keterangan',
                                type: 'textarea',
                                label: 'Keterangan',
                                placeholder: 'Tambahkan catatan jika diperlukan'
                            }
                        ]
                    })"><i
                            class="bi bi-pencil-square"></i></button>
                    <form action="{{ route('dashboard.pelatihan.tenggat.destroy', $item->id) }}" method="POST"
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
                <td colspan="7" class="text-center py-4">Belum ada tenggat upload.</td>
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
