<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pelatihan Tersedia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 16px;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    @if ($pdfSettings['show_header'] ?? true)
        <div class="header">
            <h1>DATA PELATIHAN TERSEDIA</h1>
            <p>Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Pelatihan</th>
                <th width="10%">Jenis</th>
                <th width="10%">Metode</th>
                <th width="10%">Pelaksanaan</th>
                <th width="15%">Penyelenggara</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Kuota</th>
                <th width="10%">Biaya</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelatihans as $key => $pelatihan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $pelatihan->nama_pelatihan }}</td>
                    <td>{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
                    <td>{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</td>
                    <td>{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                    <td>{{ $pelatihan->penyelenggara_pelatihan }}</td>
                    <td>{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td>{{ $pelatihan->kuota }}</td>
                    <td>Rp{{ number_format($pelatihan->biaya, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pelatihan->status_pelatihan) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($pdfSettings['show_footer'] ?? true)
        <div class="footer">
            <p>Dokumen ini dicetak secara otomatis oleh Sistem Pelatihan</p>
        </div>
    @endif
</body>

</html>
