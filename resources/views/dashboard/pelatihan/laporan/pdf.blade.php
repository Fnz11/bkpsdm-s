<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelatihan</title>
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
            <h1>LAPORAN PELATIHAN</h1>
            <p>Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Judul Laporan</th>
                <th width="30%">Latar Belakang</th>
                <th width="15%">Total Biaya</th>
                <th width="15%">Hasil Pelatihan</th>
                <th width="10%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $key => $laporan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $laporan->judul_laporan }}</td>
                    <td>{{ $laporan->latar_belakang }}</td>
                    <td class="text-right">{{ number_format($laporan->total_biaya, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($laporan->hasil_pelatihan) }}</td>
                    <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
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
