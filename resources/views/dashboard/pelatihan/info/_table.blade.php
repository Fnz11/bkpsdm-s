<thead>
    <tr>
        <th class="col-no">No</th>
        <th class="col-gambar">Gambar</th>
        <th class="col-info">Info Pelatihan</th>
        {{-- <th class="col-keterangan">Keterangan</th> --}}
        <th class="col-link">Link</th>
        <th class="col-aksi">Aksi</th>
    </tr>
</thead>
<tbody id="pelatihan-info-table">
    @forelse($pelatihans as $item)
        <tr>
            <td class="text-center col-no">{{ $pelatihans->firstItem() + $loop->index }}</td>
            <td class="text-center col-gambar">
                <a href="{{ asset('storage/' . $item->gambar) }}" target="_blank">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" class="img-thumbnail"
                        style="max-width: 120px; height: auto;">
                </a>
            </td>
            <td class="col-info">{!! \Illuminate\Support\Str::limit(strip_tags($item->info_pelatihan), 150, '...') !!}</td>
            {{-- <td class="col-keterangan">
                <a href="{{ $item->keterangan }}" target="_blank">{{ $item->keterangan }}</a>
            </td> --}}
            <td class="col-link">
                <a href="{{ $item->link_pelatihan }}" target="_blank">{{ $item->link_pelatihan }}</a>
            </td>
            <td class="text-center col-aksi">
                <a href="{{ route('dashboard.pelatihan.info.edit', $item->id) }}" class="btn btn-sm btn-warning"><i
                        class="bi bi-pencil-square"></i></a>
                <form action="{{ route('dashboard.pelatihan.info.destroy', $item->id) }}" method="POST"
                    class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data info pelatihan.</td>
        </tr>
    @endforelse
</tbody>
