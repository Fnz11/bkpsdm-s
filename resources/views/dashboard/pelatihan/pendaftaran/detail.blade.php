@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Pendaftaran Pelatihan')
@section('page-title', 'Detail Pendaftaran Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.pendaftaran') }}">Pendaftaran Pelatihan</a></li>
        <li class="breadcrumb-item active">Detail Pendaftaran</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            @php
                $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
                $isUsulan = !is_null($pendaftaran->usulan);
                $user = $pendaftaran->user;
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
                        <td>{{ $user->name ?? '-' }}</td>
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

            {{-- Tombol Kembali --}}
            <div class="text-start">
                <a href="{{ route('dashboard.pelatihan.pendaftaran') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
