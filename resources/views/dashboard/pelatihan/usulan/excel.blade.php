<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelatihan</th>
            <th>Jenis</th>
            <th>Metode</th>
            <th>Pelaksanaan</th>
            <th>Tanggal</th>
            <th>Penyelenggara</th>
            <th>Tempat</th>
            <th>Biaya (Rp)</th>
            <th>Pengusul</th>
            <th>Realisasi (Rp)</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelatihans as $i => $data)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $data->nama_pelatihan }}</td>
                <td>{{ $data->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
                <td>{{ $data->metodepelatihan->metode_pelatihan ?? '-' }}</td>
                <td>{{ $data->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d/m/Y') }}
                </td>
                <td>{{ $data->penyelenggara_pelatihan }}</td>
                <td>{{ $data->tempat_pelatihan }}</td>
                <td>{{ number_format($data->estimasi_biaya, 0, ',', '.') }}</td>
                <td>{{ $data->nip_pengusul }}</td>
                <td>{{ number_format($data->realisasi_biaya, 0, ',', '.') }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
