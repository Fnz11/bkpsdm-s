@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Laporan Pelatihan')
@section('page-title', 'Detail Laporan Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}" class="text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.laporan') }}" class="text-decoration-none">Laporan
                Pelatihan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
@endsection

@section('additional-css')
    <style>
        .info-box {
            transition: all 0.3s ease;
            border-left: 4px solid var(--bs-primary);
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-0">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detail Laporan Pelatihan</h5>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-box bg-light p-4 rounded-3 h-100">
                            <h6 class="text-primary mb-3">Informasi Utama</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-5 fw-normal text-muted">Judul Laporan</dt>
                                <dd class="col-sm-7 fw-semibold">{{ $laporan->judul_laporan }}</dd>

                                <dt class="col-sm-5 fw-normal text-muted">Latar Belakang</dt>
                                <dd class="col-sm-7 fw-semibold">{{ $laporan->latar_belakang }}</dd>

                                <dt class="col-sm-5 fw-normal text-muted">Hasil Pelatihan</dt>
                                <dd class="col-sm-7 fw-semibold">
                                    <span
                                        class="badge bg-{{ $laporan->hasil_pelatihan == 'lulus' ? 'success' : ($laporan->hasil_pelatihan == 'tidak lulus' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($laporan->hasil_pelatihan) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box bg-light p-4 rounded-3 h-100">
                            <h6 class="text-primary mb-3">Detail Biaya & Dokumen</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-5 fw-normal text-muted">Total Biaya</dt>
                                <dd class="col-sm-7 fw-semibold">Rp{{ number_format($laporan->total_biaya, 0, ',', '.') }}
                                </dd>

                                <dt class="col-sm-5 fw-normal text-muted">File Laporan</dt>
                                <dd class="col-sm-7">
                                    <a href="{{ asset('storage/' . $laporan->laporan) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-text me-1"></i> Lihat Dokumen
                                    </a>
                                </dd>

                                <dt class="col-sm-5 fw-normal text-muted">Sertifikat</dt>
                                <dd class="col-sm-7">
                                    <a href="{{ asset('storage/' . $laporan->sertifikat) }}" target="_blank"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Sertifikat
                                    </a>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <a href="{{ route('dashboard.pelatihan.laporan') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('dashboard.pelatihan.laporan.edit', $laporan->id) }}"
                            class="btn btn-warning me-2">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-calendar me-1"></i> Dibuat pada: {{ $laporan->created_at->format('d F Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
