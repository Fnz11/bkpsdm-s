<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelatihan</th>
            <th>Jenis</th>
            <th>Metode</th>
            <th>Pelaksanaan</th>
            <th>Penyelenggara</th>
            <th>Tempat</th>
            <th>Tanggal</th>
            <th>Kuota</th>
            <th>Biaya</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelatihans as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama_pelatihan }}</td>
                <td>{{ $item->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
                <td>{{ $item->metodepelatihan->metode_pelatihan ?? '-' }}</td>
                <td>{{ $item->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                <td>{{ $item->penyelenggara_pelatihan }}</td>
                <td>{{ $item->tempat_pelatihan }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                <td>{{ $item->kuota }}</td>
                <td>{{ $item->biaya }}</td>
                <td>{{ ucfirst($item->status_pelatihan) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
