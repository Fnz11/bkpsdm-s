@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Laporan Pelatihan')
@section('page-title', 'Edit Laporan Pelatihan')

@section('additional-css')
    <style>
        .file-preview {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .file-preview img {
            max-height: 150px;
            width: auto;
        }

        .form-section {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            color: #0d6efd;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}" class="text-decoration-none"><i
                    class="bi bi-house-door"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.laporan') }}" class="text-decoration-none"><i
                    class="bi bi-file-earmark-text"></i> Laporan Pelatihan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-pencil-square"></i> Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid px-0">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-warning text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2"></i> Form Edit Laporan</h5>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('dashboard.pelatihan.laporan.update', $laporan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="pendaftaran_id" value="{{ $laporan->pendaftaran_id }}">

                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-card-heading me-2"></i>Informasi Utama</h6>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="judul_laporan" class="form-label fw-semibold"><i
                                        class="bi bi-bookmark me-1"></i> Judul Laporan</label>
                                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan"
                                    value="{{ old('judul_laporan', $laporan->judul_laporan) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="latar_belakang" class="form-label fw-semibold"><i
                                        class="bi bi-text-paragraph me-1"></i> Latar Belakang</label>
                                <textarea class="form-control" id="latar_belakang" name="latar_belakang" rows="4" required>{{ old('latar_belakang', $laporan->latar_belakang) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="hasil_pelatihan" class="form-label fw-semibold"><i class="bi bi-award me-1"></i>
                                    Hasil Pelatihan</label>
                                <select class="form-select" id="hasil_pelatihan" name="hasil_pelatihan" required>
                                    <option value="revisi" {{ $laporan->hasil_pelatihan == 'proses' ? 'selected' : '' }}>
                                        Proses</option>
                                    <option value="revisi" {{ $laporan->hasil_pelatihan == 'revisi' ? 'selected' : '' }}>
                                        Revisi</option>
                                    <option value="lulus" {{ $laporan->hasil_pelatihan == 'lulus' ? 'selected' : '' }}>
                                        Lulus</option>
                                    <option value="tidak_lulus"
                                        {{ $laporan->hasil_pelatihan == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="total_biaya" class="form-label fw-semibold"><i
                                        class="bi bi-cash-stack me-1"></i> Total Biaya (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="total_biaya" name="total_biaya"
                                        value="{{ old('total_biaya', $laporan->total_biaya) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-file-earmark me-2"></i>Dokumen Pendukung</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="laporan" class="form-label fw-semibold"><i
                                        class="bi bi-file-earmark-pdf me-1"></i> File Laporan</label>
                                <input type="file" class="form-control" id="laporan" name="laporan"
                                    accept=".pdf,.doc,.docx">
                                <small class="text-muted">Format: PDF/DOCX (Maks: 5MB)</small>

                                @if ($laporan->laporan)
                                    <div class="file-preview mt-2">
                                        <a href="{{ asset('storage/' . $laporan->laporan) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i> Lihat Dokumen Saat Ini
                                        </a>
                                        <small class="d-block text-muted mt-1">Terakhir diupdate:
                                            {{ $laporan->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="sertifikat" class="form-label fw-semibold"><i
                                        class="bi bi-file-earmark-text me-1"></i> Sertifikat</label>
                                <input type="file" class="form-control" id="sertifikat" name="sertifikat"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF/JPG/PNG (Maks: 2MB)</small>

                                @if ($laporan->sertifikat)
                                    <div class="file-preview mt-2">
                                        <a href="{{ asset('storage/' . $laporan->sertifikat) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-eye me-1"></i> Lihat Sertifikat Saat Ini
                                        </a>
                                        <small class="d-block text-muted mt-1">Terakhir diupdate:
                                            {{ $laporan->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" onclick="window.history.back()" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
