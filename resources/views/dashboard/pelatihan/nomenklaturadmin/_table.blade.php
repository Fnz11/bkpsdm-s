<table class="table table-hover align-middle mb-0">
    <thead>
        <tr class="border-bottom bg-light-primary text-nowrap">
            <th class="fw-semibold col-no text-center" style="width: 50px;">No</th>
            <th class="fw-semibold col-nip">Nama Pengusul</th>
            <th class="fw-semibold col-kode">Kode Pelatihan</th>
            <th class="fw-semibold col-nama">Nama Pelatihan</th>
            <th class="fw-semibold col-jenis">Jenis Pelatihan</th>
            <th class="fw-semibold col-status">Status</th>
            <th class="fw-semibold col-keterangan">Keterangan</th>
            <th class="fw-semibold col-tanggal">Tanggal Usulan</th>
        </tr>
    </thead>
    <tbody id="namapelatihan-table">
        @forelse($namapelatihans as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">{{ $namapelatihans->firstItem() + $loop->index }}</td>
                <td class="col-nip">{{ $item->user->refPegawai->name }}</td>
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
