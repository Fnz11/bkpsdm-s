<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Usulan Pelatihan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        h2 {
            margin-bottom: 5px;
        }

        .small {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <h2>Data Usulan Pelatihan</h2>

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
</body>

</html>
