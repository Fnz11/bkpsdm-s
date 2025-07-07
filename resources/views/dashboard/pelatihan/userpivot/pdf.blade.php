<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Riwayat Pegawai</title>
    <style>
        @page {
            margin: {{ $pdfSettings['margin_top'] ?? 0.5 }}in {{ $pdfSettings['margin_right'] ?? 0.5 }}in {{ $pdfSettings['margin_bottom'] ?? 0.5 }}in {{ $pdfSettings['margin_left'] ?? 0.5 }}in;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header img {
            height: 60px;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 14pt;
            margin: 5px 0;
            color: #333;
        }

        .header p {
            font-size: 9pt;
            margin: 3px 0;
            color: #555;
        }

        .info-box {
            margin: 10px 0;
            padding: 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 9pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }

        th {
            background-color: #343a40;
            color: white;
            padding: 6px;
            text-align: center;
            border: 1px solid #454d55;
            font-weight: bold;
        }

        td {
            padding: 5px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8pt;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
        }

        .page-number:after {
            content: counter(page);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nowrap {
            white-space: nowrap;
        }

        .signature {
            margin-top: 20px;
            width: 100%;
        }

        .signature td {
            border: none;
            padding-top: 30px;
        }

        .signature p {
            margin: 0;
            padding: 0;
        }

        .signature .line {
            border-top: 1px solid #333;
            width: 200px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    @if ($pdfSettings['show_header'] ?? true)
        <div class="header">
            <!-- Uncomment if you want to add logo -->
            <!-- <img src="{{ asset('images/logo-instansi.png') }}" alt="Logo"> -->
            <h1>DATA RIWAYAT JABATAN PEGAWAI</h1>
            <p>INSTANSI/BADAN/LEMBAGA</p>
            <p>Periode:
                @if (isset($start) && isset($end))
                    {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}
                @else
                    Semua Periode
                @endif
            </p>
            <p>Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
        </div>
    @endif

    @if (isset($unitKerja) || isset($jenisAsn))
        <div class="info-box">
            <strong>Filter:</strong>
            @if (isset($unitKerja))
                | Unit Kerja: {{ \App\Models\ref_unitkerjas::find($unitKerja)->unitkerja ?? 'Semua' }}
            @endif
            @if (isset($jenisAsn))
                | Jenis ASN: {{ \App\Models\ref_jenisasns::find($jenisAsn)->jenis_asn ?? 'Semua' }}
            @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nama Pegawai</th>
                <th width="10%">NIP</th>
                <th width="15%">Unit Kerja</th>
                <th width="12%">Jabatan</th>
                <th width="8%">Golongan</th>
                <th width="10%">Pangkat</th>
                <th width="10%">Jenis ASN</th>
                <th width="7.5%">Tgl Mulai</th>
                <th width="7.5%">Tgl Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pivots as $index => $pivot)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pivot->user?->refPegawai?->name ?? '-' }}</td>
                    <td class="nowrap">{{ $pivot->nip ?? '-' }}</td>
                    <td>{{ $pivot->unitKerja?->unitkerja?->unitkerja ?? '-' }}</td>
                    <td>{{ $pivot->jabatan?->jabatan ?? '-' }}</td>
                    <td class="text-center">{{ $pivot->golongan?->golongan ?? '-' }}</td>
                    <td>{{ $pivot->golongan?->pangkat ?? '-' }}</td>
                    <td>{{ $pivot->golongan?->jenisasn?->jenis_asn ?? '-' }}</td>
                    <td class="text-center nowrap">
                        {{ $pivot->tgl_mulai ? \Carbon\Carbon::parse($pivot->tgl_mulai)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center nowrap">
                        {{ $pivot->tgl_akhir ? \Carbon\Carbon::parse($pivot->tgl_akhir)->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($pivots->count() > 0 && ($pdfSettings['show_footer'] ?? true))
        <div class="footer">
            <table class="signature">
                <tr>
                    <td width="60%"></td>
                    <td>
                        <p>Mengetahui,</p>
                        <p>Kepala Bagian Kepegawaian</p>
                        <div class="line"></div>
                        <p><strong>Nama Pejabat</strong></p>
                        <p>NIP. 123456789012345678</p>
                    </td>
                </tr>
            </table>
            <p>Halaman <span class="page-number"></span> dari {PAGE_COUNT}</p>
        </div>
    @endif
</body>

</html>
