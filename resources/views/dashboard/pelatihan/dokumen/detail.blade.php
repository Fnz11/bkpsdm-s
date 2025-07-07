@extends('layouts.Pelatihan.pelatihan-dashboard')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#"><i class="bi bi-house-door"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.dokumen') }}"><i
                    class="bi bi-file-earmark-text"></i> Dokumen</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-eye"></i> Detail</li>
    </ol>
@endsection

@section('content')
    <div class="p-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="fw-bold text-primary"><i class="bi bi-file-earmark-text me-1"></i> Informasi Dokumen
                            </h5>
                            <hr class="mt-2">
                            <dl class="row">
                                <dt class="col-sm-4">Nama Dokumen</dt>
                                <dd class="col-sm-8">{{ $dokumen->nama_dokumen }}</dd>

                                <dt class="col-sm-4">Admin</dt>
                                <dd class="col-sm-8">{{ $dokumen->admin_nip }} - {{ $dokumen->admin->name }}</dd>

                                <dt class="col-sm-4">Tanggal Upload</dt>
                                <dd class="col-sm-8">
                                    {{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->translatedFormat('d M Y H:i') }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="fw-bold text-primary"><i class="bi bi-info-circle me-1"></i> Status & Keterangan</h5>
                            <hr class="mt-2">
                            <dl class="row">
                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-8">
                                    <span
                                        class="badge bg-{{ $dokumen->status == 'diterima' ? 'success' : ($dokumen->status == 'ditolak' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($dokumen->status) }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4">Keterangan</dt>
                                <dd class="col-sm-8">{{ $dokumen->keterangan ?? '-' }}</dd>

                                <dt class="col-sm-4">File Dokumen</dt>
                                <dd class="col-sm-8">
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-text me-1"></i> Lihat Dokumen
                                    </a>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('dashboard.pelatihan.dokumen') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <div class="text-muted small">
                        <i class="bi bi-clock-history me-1"></i> Terakhir diupdate:
                        {{ \Carbon\Carbon::parse($dokumen->updated_at)->translatedFormat('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        @if ($pendaftarans->isNotEmpty())
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-people-fill me-2"></i> Daftar Pendaftar Terkait</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Pendaftaran</th>
                                    <th scope="col">Nama Pendaftar (NIP)</th>
                                    <th scope="col">Nama Pelatihan</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftarans as $index => $pendaftaran)
                                    <tr>
                                        <td class="text-center">{{ $pendaftarans->firstItem() + $index }}</td>
                                        <td class="text-center">{{ $pendaftaran->kode_pendaftaran }}</td>
                                        <td>
                                            {{ $pendaftaran->user->refPegawai->name ?? '-' }}
                                            <span class="text-muted">({{ $pendaftaran->user_nip }})</span>
                                        </td>
                                        <td>
                                            {{ $pendaftaran->tersedia->nama_pelatihan ?? ($pendaftaran->usulan->nama_pelatihan ?? '-') }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $pendaftaran->status_verifikasi == 'diterima' ? 'success' : ($pendaftaran->status_verifikasi == 'ditolak' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($pendaftaran->status_verifikasi) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 px-3 pb-3">
                        {{ $pendaftarans->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-4 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="bi bi-info-circle-fill text-primary fs-1"></i>
                    <h5 class="mt-3">Tidak ada pendaftar terkait dengan dokumen ini</h5>
                    <p class="text-muted">Dokumen ini belum digunakan dalam pendaftaran pelatihan apapun</p>
                </div>
            </div>
        @endif
    </div>
@endsection
