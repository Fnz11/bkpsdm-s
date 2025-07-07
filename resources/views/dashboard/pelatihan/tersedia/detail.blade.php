@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Pelatihan')
@section('page-title', 'Detail Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.tersedia') }}"><i
                    class="bi bi-calendar-check"></i> Pelatihan Tersedia</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-info-circle"></i> Detail Pelatihan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm ">
        <div class="card-header bg-light fw-bold">
            <i class="bi bi-info-circle me-2"></i>Informasi Detail Pelatihan
        </div>

        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">{{ $pelatihan->nama_pelatihan }}</h4>
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                    <i class="bi bi-arrow-left-circle me-1"></i>Batal
                </button>
            </div>

            {{-- Gambar Pelatihan --}}
            @if ($pelatihan->gambar)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="Gambar Pelatihan"
                        class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                </div>
            @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-tag me-1"></i><strong>Jenis Pelatihan</strong></span>
                            <span>{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-pc-display me-1"></i><strong>Metode</strong></span>
                            <span>{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-check me-1"></i><strong>Pelaksanaan</strong></span>
                            <span>{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-building me-1"></i><strong>Penyelenggara</strong></span>
                            <span>{{ $pelatihan->penyelenggara_pelatihan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-geo-alt me-1"></i><strong>Tempat</strong></span>
                            <span>{{ $pelatihan->tempat_pelatihan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-range me-1"></i><strong>Periode</strong></span>
                            <span>
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}
                                -
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d F Y') }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-x me-1"></i><strong>Tutup Pendaftaran</strong></span>
                            <span>{{ \Carbon\Carbon::parse($pelatihan->tutup_pendaftaran)->translatedFormat('d F Y') }}</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-people me-1"></i><strong>Kuota</strong></span>
                            <span>{{ $pelatihan->kuota }} peserta</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-cash-stack me-1"></i><strong>Biaya</strong></span>
                            <span>Rp{{ number_format($pelatihan->biaya, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item">
                            <span><i class="bi bi-card-text me-1"></i><strong>Deskripsi</strong></span>
                            <p class="text-muted mt-2 mb-0">{{ $pelatihan->deskripsi }}</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-toggle-on me-1"></i><strong>Status</strong></span>
                            @switch($pelatihan->status_pelatihan)
                                @case('draft')
                                    <span class="badge bg-secondary">Draft</span>
                                @break

                                @case('buka')
                                    <span class="badge bg-success">Buka</span>
                                @break

                                @case('tutup')
                                    <span class="badge bg-danger">Tutup</span>
                                @break

                                @case('selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @break

                                @default
                                    <span class="badge bg-light text-dark">-</span>
                            @endswitch
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-plus me-1"></i><strong>Dibuat</strong></span>
                            <span>{{ $pelatihan->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-check me-1"></i><strong>Terakhir Diubah</strong></span>
                            <span>{{ $pelatihan->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
