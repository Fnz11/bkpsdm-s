<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Alumni Pelatihan</title>
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

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 14pt;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11pt;
            margin-top: 0;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            page-break-inside: auto;
            font-size: 10pt;
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
            .table th:nth-child(1) {
                width: 5%;
            }

            .table th:nth-child(2) {
                width: 15%;
            }

            .table th:nth-child(3) {
                width: 20%;
            }

            .table th:nth-child(4) {
                width: 20%;
            }

            .table th:nth-child(5) {
                width: 15%;
            }

            .table th:nth-child(6) {
                width: 15%;
            }

            .table th:nth-child(7) {
                width: 10%;
            }
        @else
            /* Landscape Orientation */
            .table th:nth-child(1) {
                width: 4%;
            }

            .table th:nth-child(2) {
                width: 12%;
            }

            .table th:nth-child(3) {
                width: 18%;
            }

            .table th:nth-child(4) {
                width: 18%;
            }

            .table th:nth-child(5) {
                width: 15%;
            }

            .table th:nth-child(6) {
                width: 15%;
            }

            .table th:nth-child(7) {
                width: 10%;
            }

            .table th:nth-child(8) {
                width: 8%;
            }
        @endif

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody td:nth-child(1),
        .table tbody td:nth-child(7) {
            text-align: center;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>DAFTAR ALUMNI PELATIHAN</h1>
        <p>Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Table Section -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Unit Kerja</th>
                <th>Pelatihan</th>
                <th>Judul Laporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftarans as $pendaftaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pendaftaran->user_nip }}</td>
                    <td>{{ $pendaftaran->user->refPegawai->name ?? '-' }}</td>
                    <td>{{ $pendaftaran->user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                    <td>
                        @if ($pendaftaran->tersedia)
                            {{ $pendaftaran->tersedia->nama_pelatihan }}
                        @elseif ($pendaftaran->usulan)
                            {{ $pendaftaran->usulan->nama_pelatihan }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($pendaftaran->laporan)
                            {{ $pendaftaran->laporan->judul_laporan ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Section -->
    @if ($pdfSettings['show_footer'])
        <div class="footer">
            Dokumen ini dicetak secara elektronik pada
            {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y H:i:s') }}
        </div>
    @endif
</body>

</html>
