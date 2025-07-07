<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Registrasi Pelatihan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

    <h2>Laporan Registrasi Pelatihan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>ID Pelatihan</th>
                <th>Tanggal Daftar</th>
                <th>Biaya Pelatihan</th>
                <th>Biaya Akomodasi</th>
                <th>Biaya Hotel</th>
                <th>Uang Harian</th>
                <th>File Penawaran</th>
                <th>File Usulan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrasis as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->nip }}</td>
                <td>{{ $item->id_pelatihan }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d-m-Y') }}</td>
                <td>Rp{{ number_format($item->biaya_pelatihan, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->biaya_akomodasi, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->biaya_hotel, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->uang_harian, 0, ',', '.') }}</td>
                <td>{{ $item->file_penawaran }}</td>
                <td>{{ $item->file_usulan }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><small>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</small></p>

</body>
</html>
