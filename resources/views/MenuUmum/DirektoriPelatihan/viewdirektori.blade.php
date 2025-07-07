<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Laporan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th {
            width: 25%;
            background-color: #f8f9fa;
        }
        td {
            width: 75%;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .btn-back {
            background-color: #795548;
            color: white;
        }
        .btn-back:hover {
            background-color: #5d4037;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="fw-bold">Detail Laporan Pelatihan</h4>
            </div>
            <div class="card-body bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>NIP</th>
                                <td>
                                    {{ $laporan->nip }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>
                                    {{ $laporan->nama }}
                                </td>
                            </tr>
                            <tr>
                                <th>Golongan Ruang</th>
                                <td>
                                    {{ $laporan->golongan_ruang }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>
                                    {{ $laporan->jabatan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Unit Kerja</th>
                                <td>
                                    {{ $laporan->unit_kerja }}
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    {{ $laporan->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Pelatihan</th>
                                <td>
                                    {{ $laporan->nama_pelatihan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Pelaksanaan Pelatihan</th>
                                <td>
                                    {{ $laporan->pelaksanaan_pelatihan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Penyelenggara Pelatihan</th>
                                <td>
                                    {{ $laporan->penyelenggara_pelatihan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Rumpun Pelatihan</th>
                                <td>
                                    {{ $laporan->rumpun_pelatihan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>
                                    {{ $laporan->tanggal_mulai }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>
                                    {{ $laporan->tanggal_selesai }}
                                </td>
                            </tr>
                            <tr>
                                <th>Hasil Pelatihan</th>
                                <td>
                                    {{ ucfirst($laporan->hasil_pelatihan) }}
                                </td>
                            </tr>
                            <tr>
                                <th>Judul Laporan</th>
                                <td>
                                    {{ $laporan->judul_laporan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Abstrak Laporan</th>
                                <td>
                                    {{ $laporan->abstrak_laporan }}
                                </td>
                            </tr>
                            <tr>
                                <th>Link Laporan</th>
                                <td><a href="{{ $laporan->link_laporan }}" target="_blank">Buka Laporan</a></td>
                            </tr>
                            <tr>
                                <th>Status Peserta</th>
                                <td>
                                    {{ $laporan->Status_peserta }}
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>
                                    {{ $laporan->keterangan ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td>
                                    @if ($laporan->foto)
                                        <img src="{{ asset('storage/' . $laporan->foto) }}" class="img-fluid"
                                            style="max-height: 200px;">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Sertifikat</th>
                                <td>
                                    @if ($laporan->sertifikat)
                                        <a href="{{ asset('storage/' . $laporan->sertifikat) }}" target="_blank"
                                            class="btn btn-success btn-sm">Lihat Sertifikat</a>
                                    @else
                                        Tidak ada sertifikat
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
<!-- Tombol Kembali -->
<div class="text-center mt-3">
    <a href="{{ route('DirektoriPelatihan.direktori') }}" class="btn btn-back">
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
