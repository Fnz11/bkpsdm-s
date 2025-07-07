@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Pendaftaran Pelatihan')
@section('page-title', 'Edit Pendaftaran Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.pendaftaran') }}">Pendaftaran Pelatihan</a></li>
        <li class="breadcrumb-item active">Edit Pendaftaran Pelatihan</li>
    </ol>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('dashboard.pelatihan.pendaftaran.update', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @php
                $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
                $isUsulan = !is_null($pendaftaran->usulan);
                $user = $pendaftaran->user;
            @endphp

            {{-- Detail Pelatihan --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Pelatihan</h5>
                @if (!$isUsulan)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="Gambar Pelatihan" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $pelatihan->nama_pelatihan ?? '-' }}</td>
                                <th>Jenis</th>
                                <td>{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Metode</th>
                                <td>{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</td>
                                <th>Pelaksanaan</th>
                                <td>{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Penyelenggara</th>
                                <td>{{ $pelatihan->penyelenggara_pelatihan ?? '-' }}</td>
                                <th>Tempat</th>
                                <td>{{ $pelatihan->tempat_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td colspan="3">{{ $pelatihan->tanggal_mulai ?? '-' }} s.d. {{ $pelatihan->tanggal_selesai ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Biaya</th>
                                <td colspan="3">
                                    @if ($isUsulan)
                                        Estimasi: Rp{{ number_format($pelatihan->estimasi_biaya ?? 0, 0, ',', '.') }} <br>
                                        <div class="mt-2 d-flex align-items-center">
                                            <label for="real-biaya" class="form-label me-2 mb-0 fw-semibold">Realisasi Biaya</label>
                                            <input id="real-biaya" type="number" name="realisasi_biaya" step="500" min="0" class="form-control form-control-sm w-auto" value="{{ old('realisasi_biaya', $pelatihan->realisasi_biaya ?? 0) }}">
                                        </div>
                                    @else
                                        Rp{{ number_format($pelatihan->biaya ?? 0, 0, ',', '.') }}
                                    @endif
                                </td>
                            </tr>
                            @if ($isUsulan)
                            <tr>
                                <th>File Penawaran</th>
                                <td colspan="3">
                                    <a href="{{ asset('storage/' . $pendaftaran->usulan->file_penawaran) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-file-earmark-text me-1"></i>Lihat File
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Detail Pendaftar --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Pendaftar</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->name ?? '-' }}</td>
                                <th>NIP</th>
                                <td>{{ $user->nip ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email ?? '-' }}</td>
                                <th>No. HP</th>
                                <td>{{ $user->refPegawai->no_hp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $user->refPegawai->alamat ?? '-' }}</td>
                                <th>Unit Kerja</th>
                                <td>{{ $user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sub Unit</th>
                                <td>{{ $user->latestUserPivot->unitKerja->sub_unitkerja ?? '-' }}</td>
                                <th>Jabatan</th>
                                <td>{{ $user->latestUserPivot->jabatan->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Golongan</th>
                                <td>{{ $user->latestUserPivot->golongan->pangkat_golongan ?? '-' }}</td>
                                <th>Jenis ASN</th>
                                <td>{{ $user->latestUserPivot->golongan->jenisasn->jenis_asn ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pendaftaran --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Data Pendaftaran</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kode Pendaftaran</label>
                        <input type="text" class="form-control" value="{{ $pendaftaran->kode_pendaftaran }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Pendaftaran</label>
                        <input type="date" class="form-control" value="{{ $pendaftaran->tanggal_pendaftaran }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status Verifikasi</label>
                        <select name="status_verifikasi" class="form-select">
                            @foreach (['tersimpan', 'tercetak', 'terkirim', 'diterima', 'ditolak'] as $status)
                                <option value="{{ $status }}" {{ old('status_verifikasi', $pendaftaran->status_verifikasi) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status Peserta</label>
                        <select name="status_peserta" class="form-select">
                            @foreach (['pendaftar', 'peserta', 'alumni'] as $status)
                                <option value="{{ $status }}" {{ old('status_peserta', $pendaftaran->status_peserta) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $pendaftaran->keterangan) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="text-end">
                <a href="{{ route('dashboard.pelatihan.pendaftaran') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
