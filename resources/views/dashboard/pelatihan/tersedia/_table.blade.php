<thead class="bg-light-primary">
    <tr>
        <th class="col-no">No</th>
        <th class="col-nama">Nama Pelatihan</th>
        <th class="col-jenis">Jenis Pelatihan</th>
        <th class="col-metode">Metode Pelatihan</th>
        <th class="col-pelaksanaan">Pelaksanaan Pelatihan</th>
        <th class="col-penyelenggara">Penyelenggara</th>
        <th class="col-tempat">Tempat</th>
        <th class="col-tanggal">Tanggal Pelaksanaan</th>
        <th class="col-kuota">Kuota</th>
        <th class="col-biaya">Biaya</th>
        <th class="col-status">Status</th>
        <th class="col-aksi text-center">Aksi</th>
    </tr>
</thead>
<tbody id="tersedia-table">
    @forelse ($pelatihans as $item)
        <tr class="border-bottom">
            <td class="text-center col-no">{{ $pelatihans->firstItem() + $loop->index }}</td>
            <td class="col-nama">{{ $item->nama_pelatihan }}</td>
            <td class="col-jenis">{{ $item->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
            <td class="col-metode">{{ $item->metodepelatihan->metode_pelatihan ?? '-' }}</td>
            <td class="col-pelaksanaan">{{ $item->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
            <td class="col-penyelenggara">{{ $item->penyelenggara_pelatihan }}</td>
            <td class="col-tempat">{{ $item->tempat_pelatihan }}</td>
            <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
            <td class="col-kuota">{{ $item->kuota }}</td>
            <td class="col-biaya">Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
            <td class="col-status">
                <span
                    class="badge bg-{{ $item->status_pelatihan == 'buka'
                        ? 'success'
                        : ($item->status_pelatihan == 'tutup'
                            ? 'danger'
                            : ($item->status_pelatihan == 'selesai'
                                ? 'primary'
                                : 'secondary')) }}">
                    {{ ucfirst($item->status_pelatihan) }}
                </span>
            </td>
            <td class="col-aksi text-center gap-2">
                <a href="{{ route('dashboard.pelatihan.tersedia.show', $item->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('dashboard.pelatihan.tersedia.edit', $item->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form method="POST" action="{{ route('dashboard.pelatihan.tersedia.destroy', $item->id) }}"
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
            <td colspan="12" class="text-center py-4">Tidak ada data pelatihan yang tersedia.</td>
        </tr>
    @endforelse
</tbody>
