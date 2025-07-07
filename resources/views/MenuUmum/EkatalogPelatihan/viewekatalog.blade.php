<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pelatihan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th {
            width: 25%; /* Lebar kolom judul */
            background-color: #f8f9fa; /* Warna latar belakang */
        }
        td {
            width: 75%; /* Lebar kolom isi */
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .btn-back {
            background-color: #795548; /* Warna coklat */
            color: white;
        }
        .btn-back:hover {
            background-color: #5d4037; /* Warna lebih gelap saat hover */
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="fw-bold">Data Pelatihan</h4>
            </div>
            <div class="card-body bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Rumpun Pelatihan</th>
                                <td>{{ $usulan_laporan_diklat->rumpun_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pelatihan</th>
                                <td>{{ $usulan_laporan_diklat->jenis_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pelatihan</th>
                                <td>{{ $usulan_laporan_diklat->nama_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Informasi Pelatihan</th>
                                <td>{{ $usulan_laporan_diklat->informasi_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Penyelenggara</th>
                                <td>{{ $usulan_laporan_diklat->nama_penyelenggara ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama CP</th>
                                <td>{{ $usulan_laporan_diklat->nama_CP ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>{{ $usulan_laporan_diklat->no_HP ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pelaksanaan</th>
                                <td>{{ $usulan_laporan_diklat->metode_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pelaksanaan Pelatihan</th>
                                <td>{{ $usulan_laporan_diklat->pelaksanaan_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Estimasi Biaya</th>
                                <td>Rp {{ number_format($usulan_laporan_diklat->estimasi_biaya, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $usulan_laporan_diklat->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>File Pelatihan</th>
                                <td>
                                    @if ($usulan_laporan_diklat->file_pelatihan)
                                        <a href="{{ asset('storage/' . $usulan_laporan_diklat->file_pelatihan) }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fas fa-file-download"></i> Lihat File
                                        </a>
                                    @else
                                        <p class="text-muted">Tidak ada file</p>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Back -->
                <div class="text-center mt-3">
                    <a href="{{ route('EkatalogPelatihan.ekatalog') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
