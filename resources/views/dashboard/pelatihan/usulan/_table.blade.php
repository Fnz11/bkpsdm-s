<thead class="bg-light-primary">
    <tr>
        <th class="text-center col-no">No</th>
        <th class="col-nip">NIP Pengusul</th>
        <th class="col-uk">Nama Pelatihan</th>
        <th class="col-nama">Nama Pelatihan</th>
        <th class="col-jenis">Jenis Pelatihan</th>
        <th class="col-metode">Metode Pelatihan</th>
        <th class="col-pelaksanaan">Pelaksanaan</th>
        <th class="col-penyelenggara">Penyelenggara</th>
        <th class="col-tempat">Tempat</th>
        <th class="col-tanggal">Tanggal Pelaksanaan</th>
        <th class="col-file">File Penawaran</th>
        <th class="col-estimasi">Estimasi Biaya</th>
        <th class="col-realisasi">Realisasi Biaya</th>
        <th class="col-keterangan">Keterangan</th>
        @if (auth()->user()->hasRole('superadmin'))
            <th class="text-end col-aksi">Aksi</th>
        @endif
    </tr>
</thead>
<tbody id="usulan-table">
    @forelse ($pelatihan as $item)
        <tr>
            <td class="text-center col-no">{{ $loop->iteration }}</td>
            <td class="col-nip">{{ $item->nip_pengusul }}</td>
            <td class="col-uk">{{ $item->user->latestUserPivot->unitKerja->unitkerja->unitkerja }}</td>
            <td class="col-nama">{{ $item->nama_pelatihan }}</td>
            <td class="col-jenis">{{ $item->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
            <td class="col-metode">{{ $item->metodepelatihan->metode_pelatihan ?? '-' }}</td>
            <td class="col-pelaksanaan">{{ $item->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
            <td class="col-penyelenggara">{{ $item->penyelenggara_pelatihan }}</td>
            <td class="col-tempat">{{ $item->tempat_pelatihan }}</td>
            <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
            <td class="col-file">
                <a href="{{ asset('storage/' . $item->file_penawaran) }}" target="_blank"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-file-earmark-text"></i> Lihat
                </a>
            </td>
            <td class="col-estimasi">Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}</td>
            <td class="col-realisasi">
                {{ $item->realisasi_biaya ? 'Rp ' . number_format($item->realisasi_biaya, 0, ',', '.') : '-' }}
            </td>
            <td class="col-keterangan">{{ $item->keterangan }}</td>
            @if (auth()->user()->hasRole('superadmin'))
            <td class="text-end col-aksi g-1">
                <a href="{{ route('dashboard.pelatihan.usulan.show', $item->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('dashboard.pelatihan.usulan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('dashboard.pelatihan.usulan.destroy', $item->id) }}" method="POST"
                    class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                        data-form-id="form-{{ $item->id }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="14" class="text-center">Tidak ada data pelatihan.</td>
        </tr>
    @endforelse
</tbody>
