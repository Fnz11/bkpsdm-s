<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pendaftaran Pelatihan</title>
    <style>
        @page {
            size: {{ $pdfSettings['paper_size'] }} {{ $pdfSettings['orientation'] }};
            margin-top: {{ $pdfSettings['margin_top'] }}in;
            margin-right: {{ $pdfSettings['margin_right'] }}in;
            margin-bottom: {{ $pdfSettings['margin_bottom'] }}in;
            margin-left: {{ $pdfSettings['margin_left'] }}in;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            margin: 0;
            padding: 0;
            color: #000;
        }

        /* Header and Footer Control */
        /* @if (!$pdfSettings['show_header'])
        @page {
            margin-top: 0;
        }

        .header-space {
            height: 0;
        }
        @endif
        */ @if (!$pdfSettings['show_footer'])
            @page {
                margin-bottom: 0;
            }

            .footer-space {
                height: 0;
            }
        @endif

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .underline {
            text-decoration: underline;
        }

        /* Lampiran Section */
        .lampiran {
            width: 100%;
            /* padding-bottom: 1.5in; */
            margin-bottom: 1in;
            /* Tambahan jarak ke judul */
        }

        .lampiran-content {
            float: right;
            text-align: left;
            font-size: 11pt;
        }

        .lampiran-title {
            margin-bottom: 4px;
        }

        .lampiran-table {
            border: none;
            margin-left: -2px;
        }

        .lampiran-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* Judul Section */
        .judul {
            clear: both;
            text-align: center;
            margin: 0 0 30px;
        }

        .judul h2 {
            font-size: 14pt;
            margin: 5px 0;
            letter-spacing: 0.5px;
        }

        /* Table Styles - Different for portrait and landscape */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            page-break-inside: auto;
            font-size: 11pt;
        }

        .table th {
            background-color: #f2f2f2;
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: center;
            font-weight: bold;
        }

        .table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }

        /* Portrait Orientation */
        @if ($pdfSettings['orientation'] == 'portrait')
            .table {
                font-size: 10pt;
            }

            .table th,
            .table td {
                padding: 4px 6px;
            }

            .table thead th:nth-child(1) {
                width: 5%;
            }

            .table thead th:nth-child(2) {
                width: 15%;
            }

            .table thead th:nth-child(3) {
                width: 20%;
            }

            .table thead th:nth-child(4) {
                width: 25%;
            }

            .table thead th:nth-child(5) {
                width: 20%;
            }

            .table thead th:nth-child(6) {
                width: 15%;
            }
        @else
            /* Landscape Orientation */
            .table {
                font-size: 11pt;
            }

            .table thead th:nth-child(1) {
                width: 4%;
            }

            .table thead th:nth-child(2) {
                width: 12%;
            }

            .table thead th:nth-child(3) {
                width: 18%;
            }

            .table thead th:nth-child(4) {
                width: 33%;
            }

            .table thead th:nth-child(5) {
                width: 20%;
            }

            .table thead th:nth-child(6) {
                width: 13%;
            }
        @endif

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody td:nth-child(1),
        .table tbody td:nth-child(6) {
            text-align: center;
        }

        /* TTD Section */
        .ttd-container {
            margin-top: 40px;
            position: relative;
            page-break-inside: avoid;
            page-break-before: auto;
        }

        .ttd {
            width: 300px;
            margin-left: auto;
            text-align: center;
        }

        .ttd-title {
            margin-bottom: 5px;
        }

        .ttd-space {
            height: 80px;
            margin: 10px 0;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }

        .ttd-details {
            margin-top: 3px;
            font-size: 11pt;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        /* Page break handling */
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    </style>
</head>

<body>
    <!-- Header Space -->
    @if ($pdfSettings['show_header'])
        <!-- Lampiran Section -->
        <div class="lampiran">
            <div class="lampiran-content">
                <div class="lampiran-title">Lampiran Surat Kepala {{ $unitkerja }} Kota Surakarta</div>
                <table class="lampiran-table">
                    <tr>
                        <td style="width: 70px;">Nomor</td>
                        <td style="width: 10px;">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <!-- Judul Section -->
    <div class="judul">
        <h2 class="fw-bold">DAFTAR USULAN PELATIHAN</h2>
        <h2 class="fw-bold">{{ strtoupper($unitkerja) }}</h2>
        <h2 class="fw-bold">TAHUN {{ \Carbon\Carbon::now('Asia/Jakarta')->year }}</h2>
    </div>

    <!-- Table Section -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Nama Pelatihan</th>
                <th>Unit Kerja</th>
                <th>Jenis Usulan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftarans as $pendaftaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pendaftaran->user->nip }}</td>
                    <td>{{ $pendaftaran->user->refPegawai->name }}</td>
                    <td>
                        @if ($pendaftaran->tersedia)
                            {{ $pendaftaran->tersedia->nama_pelatihan }}
                        @elseif ($pendaftaran->usulan)
                            {{ $pendaftaran->usulan->nama_pelatihan }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ ucfirst($pendaftaran->user->latestUserPivot->unitKerja->unitkerja->unitkerja) }}</td>
                    <td>
                        {{ $pendaftaran->tersedia ? 'Pelatihan Umum' : ($pendaftaran->usulan ? 'Pelatihan Khusus' : '-') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($pdfSettings['show_signature'])
        <!-- Tanda Tangan Section -->
        <div class="ttd-container">
            <div class="ttd">
                <div class="ttd-title mb-1">Surakarta,
                    {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
                @if ($pj === 'manual')
                    <div class="ttd-title mb-1">a.n. Kepala {{ ucwords($unitkerja) }}</div>
                    <div class="ttd-title mb-1">{{ $user->jabatan }}</div>
                @else
                    <div class="ttd-title mb-1">Kepala {{ ucwords($unitkerja) }}</div>
                @endif
                <div class="ttd-space"></div>
                <div class="ttd-name">{{ $user->nama }}</div>
                <div class="ttd-details">{{ $user->pangkat }}</div>
                <div class="ttd-details">NIP. {{ $user->nip }}</div>
            </div>
        </div>
    @endif

    <!-- Footer Section -->
    @if ($pdfSettings['show_footer'])
        <div class="footer-space">
            <div class="footer">
                Dokumen ini dicetak secara elektronik pada
                {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y H:i:s') }}
            </div>
        </div>
    @endif
</body>

</html>
