<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .header p {
            font-size: 12px;
            margin: 5px 0 0 0;
            padding: 0;
        }

        .filter-info {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .filter-info table {
            width: 100%;
        }

        .filter-info td {
            padding: 3px 5px;
        }

        .filter-info td:first-child {
            font-weight: bold;
            width: 30%;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        table.data th {
            background-color: #f2f2f2;
            text-align: center;
        }

        table.data td {
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="filter-info">
        <table>
            <tr>
                <td>Pencarian</td>
                <td>{{ $filterInfo['search'] }}</td>
            </tr>
            <tr>
                <td>Tanggal Pendaftaran</td>
                <td>{{ $filterInfo['date_range'] }}</td>
            </tr>
            <tr>
                <td>Jumlah Data</td>
                <td>{{ $filterInfo['total_data'] }}</td>
            </tr>
            <tr>
                <td>Ukuran Kertas</td>
                <td>{{ $filterInfo['paper_size'] }}</td>
            </tr>
            <tr>
                <td>Orientasi</td>
                <td>{{ $filterInfo['orientation'] }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>{{ $jenisRekap === 'pelatihan' ? 'Nama Pelatihan' : 'Nama OPD' }}</th>
                <th width="15%">Jumlah Usulan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama ?? ($item->opd ?? '-') }}</td>
                    <td style="text-align: center">{{ $item->jumlah_usulan ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh sistem pada {{ date('d/m/Y H:i:s') }}
    </div>
</body>

</html>
