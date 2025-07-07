<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pendaftaran Pelatihan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 40px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        .data-table td {
            padding: 6px;
        }

        .signature {
            width: 100%;
            margin-top: 50px;
        }

        .signature td {
            text-align: right;
            padding-right: 20px;
        }

        .text-bold {
            font-weight: bold;
        }

        .mt-3 {
            margin-top: 30px;
        }

    </style>
</head>
<body>

    <h2>Surat Pendaftaran Pelatihan</h2>

    <p>Dengan ini kami menyampaikan pendaftaran pelatihan dengan rincian sebagai berikut:</p>

    <table class="data-table">
        <tr>
            <td class="text-bold">NIP</td>
            <td>: {{ $data->user->nip }}</td>
        </tr>
        <tr>
            <td class="text-bold">ID Pelatihan</td>
            <td>: {{ $data->pelatihan->nama_pelatihan }}</td>
        </tr>
        <tr>
            <td class="text-bold">Tanggal Daftar</td>
            <td>: {{ \Carbon\Carbon::parse($data->tanggal_daftar)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="text-bold">Biaya Pelatihan</td>
            <td>: Rp{{ number_format($data->biaya_pelatihan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-bold">Biaya Akomodasi</td>
            <td>: Rp{{ number_format($data->biaya_akomodasi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-bold">Biaya Hotel</td>
            <td>: Rp{{ number_format($data->biaya_hotel, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-bold">Uang Harian</td>
            <td>: Rp{{ number_format($data->uang_harian, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-bold">File Penawaran</td>
            <td>: {{ $data->file_penawaran }}</td>
        </tr>
        <tr>
            <td class="text-bold">File Usulan</td>
            <td>: {{ $data->file_usulan }}</td>
        </tr>
        <tr>
            <td class="text-bold">Status</td>
            <td>: {{ ucfirst($data->status) }}</td>
        </tr>
    </table>

    <table class="signature">
        <tr>
            <td>
                Surakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Hormat kami,<br><br><br><br>
                <u>............................................</u><br>
                ({{ $data->user->name }})<br>
            </td>
        </tr>
    </table>

</body>
</html>
