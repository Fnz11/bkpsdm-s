@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Alumni')
@section('page-title', 'Detail Alumni')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.alumni') }}">Data Alumni</a></li>
        <li class="breadcrumb-item active">Detail Alumni</li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-body">

            @php
                $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
                $isUsulan = !is_null($pendaftaran->usulan);
                $user = $pendaftaran->user;
                $laporan = $pendaftaran->laporan;
            @endphp

            {{-- Detail Pelatihan --}}
            <h5 class="fw-bold mb-3">📝 Informasi Pelatihan</h5>
            @if (!$isUsulan)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="img-fluid rounded shadow-sm"
                        style="max-height: 200px;" alt="Gambar Pelatihan">
                </div>
            @endif
            <table class="table table-bordered table-striped mb-4">
                <tbody>
                    <tr>
                        <th width="30%">Nama Pelatihan</th>
                        <td>{{ $pelatihan->nama_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Metode</th>
                        <td>{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pelaksanaan</th>
                        <td>{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penyelenggara</th>
                        <td>{{ $pelatihan->penyelenggara_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tempat</th>
                        <td>{{ $pelatihan->tempat_pelatihan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>
                            {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}
                            s.d.
                            {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    @if ($isUsulan)
                        <tr>
                            <th>Estimasi Biaya</th>
                            <td>Rp{{ number_format($pelatihan->estimasi_biaya ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Realisasi Biaya</th>
                            <td>Rp{{ number_format($pelatihan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>File Penawaran</th>
                            <td><a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}" target="_blank">📄 Lihat
                                    File</a></td>
                        </tr>
                    @else
                        <tr>
                            <th>Biaya</th>
                            <td>Rp{{ number_format($pelatihan->biaya ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- Detail Pendaftar --}}
            <h5 class="fw-bold mb-3">👤 Informasi Pendaftar</h5>
            <table class="table table-bordered table-striped mb-4">
                <tbody>
                    <tr>
                        <th width="30%">Nama</th>
                        <td>{{ $user->refPegawai->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $user->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $user->refPegawai->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->refPegawai->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td>{{ $user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sub Unit Kerja</th>
                        <td>{{ $user->latestUserPivot->unitKerja->sub_unitkerja ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori Jabatan</th>
                        <td>{{ $user->latestUserPivot->jabatan->kategorijabatan->kategori_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>{{ $user->latestUserPivot->jabatan->jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pangkat (Golongan)</th>
                        <td>{{ $user->latestUserPivot->golongan->pangkat_golongan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis ASN</th>
                        <td>{{ $user->latestUserPivot->golongan->jenisasn->jenis_asn ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Detail Pendaftaran --}}
            <h5 class="fw-bold mb-3">📌 Informasi Pendaftaran</h5>
            <table class="table table-bordered table-striped mb-4">
                <tbody>
                    <tr>
                        <th width="30%">Kode Pendaftaran</th>
                        <td>{{ $pendaftaran->kode_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pendaftaran</th>
                        <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status Verifikasi</th>
                        <td>
                            <span
                                class="badge bg-{{ $pendaftaran->status_verifikasi == 'diterima' ? 'success' : ($pendaftaran->status_verifikasi == 'ditolak' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($pendaftaran->status_verifikasi) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Peserta</th>
                        <td>
                            <span
                                class="badge bg-{{ $pendaftaran->status_peserta == 'peserta' ? 'primary' : ($pendaftaran->status_peserta == 'alumni' ? 'success' : 'warning') }}">
                                {{ ucwords(str_replace('_', ' ', $pendaftaran->status_peserta)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $pendaftaran->keterangan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Section Laporan Pelatihan --}}
            @if ($pendaftaran->status_peserta == 'alumni')
                <h5 class="fw-bold mb-3">📊 Laporan Pelatihan</h5>
                @if ($laporan)
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="30%">Judul Laporan</th>
                                <td>{{ $laporan->judul_laporan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Latar Belakang</th>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1"
                                            style="max-height: 100px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $laporan->latar_belakang ?? '-' }}
                                        </div>
                                        @if (strlen($laporan->latar_belakang ?? '') > 100)
                                            <button class="btn btn-sm btn-link p-0 ms-2" data-bs-toggle="collapse"
                                                data-bs-target="#latarBelakangCollapse{{ $loop->index ?? '' }}"
                                                aria-expanded="false"
                                                aria-controls="latarBelakangCollapse{{ $loop->index ?? '' }}">
                                                <i class="bi bi-chevron-down"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @if (strlen($laporan->latar_belakang ?? '') > 100)
                                        <div class="collapse" id="latarBelakangCollapse{{ $loop->index ?? '' }}">
                                            <div class="card card-body mt-2 p-2 bg-light" style="white-space: pre-wrap;">
                                                {{ $laporan->latar_belakang }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Hasil Pelatihan</th>
                                <td>
                                    <span
                                        class="badge 
                                            @if ($laporan->hasil_pelatihan == 'lulus') bg-success
                                            @elseif($laporan->hasil_pelatihan == 'tidak_lulus') bg-danger
                                            @elseif($laporan->hasil_pelatihan == 'revisi') bg-warning
                                            @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $laporan->hasil_pelatihan)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Biaya</th>
                                <td>Rp{{ number_format($laporan->total_biaya ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Sertifikat</th>
                                <td>
                                    @if ($laporan->sertifikat)
                                        <a href="{{ asset('storage/' . $laporan->sertifikat) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-pdf"></i> Lihat Sertifikat
                                        </a>
                                        <a href="{{ asset('storage/' . $laporan->sertifikat) }}" download
                                            class="btn btn-sm btn-outline-success ms-2">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>File Laporan</th>
                                <td>
                                    @if ($laporan->laporan)
                                        <a href="{{ asset('storage/' . $laporan->laporan) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-text"></i> Lihat Laporan
                                        </a>
                                        <a href="{{ asset('storage/' . $laporan->laporan) }}" download
                                            class="btn btn-sm btn-outline-success ms-2">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Upload</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y H:i') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Belum ada laporan pelatihan yang diupload.
                    </div>
                @endif
            @endif

            {{-- Tombol Kembali --}}
            <div class="text-start">
                <a href="{{ route('dashboard.pelatihan.alumni') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
