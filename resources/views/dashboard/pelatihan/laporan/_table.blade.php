<thead>
    <tr class="border-bottom bg-light-primary text-nowrap text-center">
        <th class="col-no">No</th>
        <th class="col-nama">Nama Pelatihan</th>
        <th class="col-judul">Judul</th>
        <th class="col-latar">Latar Belakang</th>
        <th class="col-hasil">Hasil</th>
        <th class="col-biaya">Total Biaya</th>
        <th class="col-laporan">Laporan</th>
        <th class="col-sertifikat">Sertifikat</th>
        <th class="col-aksi">Aksi</th>
    </tr>
</thead>
<tbody id="laporan-table">
    @forelse($laporans as $item)
        <tr class="border-bottom">
            <td class="text-center col-no">{{ $laporans->firstItem() + $loop->index }}</td>
            <td class="col-nama">
                {{ $item->pendaftaran?->tersedia?->nama_pelatihan ?? ($item->pendaftaran?->usulan?->nama_pelatihan ?? '-') }}
            </td>
            <td class="col-judul">{{ $item->judul_laporan }}</td>
            <td class="col-latar">{{ $item->latar_belakang }}</td>
            <td class="col-hasil"><span
                    class="badge 
                @if ($item->hasil_pelatihan === 'lulus') bg-success
                @elseif($item->hasil_pelatihan === 'tidak_lulus') bg-danger
                @elseif($item->hasil_pelatihan === 'revisi') bg-warning
                @else bg-secondary @endif">
                    {{ ucfirst(str_replace('_', ' ', $item->hasil_pelatihan)) }}
                </span></td>
            <td class="col-biaya">Rp{{ number_format($item->total_biaya, 0, ',', '.') }}</td>
            <td class="col-laporan">
                @if ($item->laporan)
                    <a class ="btn btn-outline-primary btn-sm" href="{{ asset('storage/' . $item->laporan) }}"
                        target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat
                    </a>
                @else
                    -
                @endif
            </td>
            <td class="col-sertifikat">
                @if ($item->sertifikat)
                    <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/' . $item->sertifikat) }}"
                        target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat
                    </a>
                @else
                    -
                @endif
            </td>
            <td class="col-aksi text-center gap-2">
                <a href="{{ route('dashboard.pelatihan.laporan.show', $item->id) }}" class="btn btn-sm btn-primary"
                    title="Detail">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('dashboard.pelatihan.laporan.edit', $item->id) }}" class="btn btn-sm btn-warning"
                    title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('dashboard.pelatihan.laporan.destroy', $item->id) }}" method="POST"
                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data laporan.</td>
        </tr>
    @endforelse
</tbody>
