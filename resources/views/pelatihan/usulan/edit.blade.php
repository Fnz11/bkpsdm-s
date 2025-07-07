@extends('layouts.pelatihan.app')

@section('title', 'Edit Usulan Pelatihan')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <nav aria-label="breadcrumb" class="hero-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('pelatihan.usulan.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Usulan Pelatihan
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pelatihan.usulan.show', $usulan->id) }}" class="breadcrumb-link">
                                    Detail Usulan
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Usulan</li>
                        </ol>
                    </nav>
                    <h1 class="hero-title">
                        <i class="bi bi-pencil-square me-3"></i>
                        Edit Usulan Pelatihan
                    </h1>
                    <p class="hero-subtitle">Perbarui data usulan pelatihan dengan informasi terbaru</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.usulan.show', $usulan->id) }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div class="info-content">
                <h6 class="info-title">Informasi Penting</h6>
                <p class="info-text">
                    Pastikan semua perubahan data adalah akurat dan sesuai dengan kebutuhan pelatihan. 
                    Setelah disimpan, usulan akan kembali ke status tersimpan. 
                    <span class="status-highlight status-saved">File penawaran</span> baru akan menggantikan file sebelumnya jika diunggah.
                </p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="main-card">
            <form action="{{ route('pelatihan.usulan.update', $usulan->id) }}" method="POST" enctype="multipart/form-data" class="modern-form" id="pelatihanForm">
                @csrf
                @method('PUT')
                
                <!-- Nama Pelatihan Section -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="bi bi-bookmark-fill me-2"></i>
                        Informasi Pelatihan
                    </h5>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-mortarboard me-2"></i>
                            Nama Pelatihan
                            <span class="required">*</span>
                        </label>
                        <select name="nama_pelatihan" class="form-select modern-select select2" required>
                            <option value="">-- Pilih Nama Pelatihan --</option>
                            @foreach ($namaPelatihan as $nama)
                                <option value="{{ $nama->nama_pelatihan }}" {{ $usulan->nama_pelatihan == $nama->nama_pelatihan ? 'selected' : '' }}>
                                    {{ $nama->nama_pelatihan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-help">
                            <div class="help-content">
                                <p class="help-text">
                                    <i class="bi bi-lightbulb me-1"></i>
                                    Apabila nama pelatihan tidak tersedia, silakan usulkan nama pelatihan baru terlebih dahulu
                                </p>
                                <a href="{{ route('pelatihan.create-nomenklatur') }}" class="btn btn-elegant btn-success btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Usul Nama Pelatihan
                                </a>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-clock me-1"></i>
                                Usulan nama pelatihan akan diverifikasi dan tunggu hingga disetujui
                            </small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Pelaksanaan Pelatihan
                                    <span class="required">*</span>
                                </label>
                                <select name="pelaksanaanpelatihan_id" class="form-select modern-select" required>
                                    <option value="">-- Pilih Pelaksanaan --</option>
                                    @foreach ($pelaksanaanPelatihan as $pelaksanaan)
                                        <option value="{{ $pelaksanaan->id }}" {{ $usulan->pelaksanaanpelatihan_id == $pelaksanaan->id ? 'selected' : '' }}>
                                            {{ $pelaksanaan->pelaksanaan_pelatihan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-laptop me-2"></i>
                                    Metode Pelatihan
                                    <span class="required">*</span>
                                </label>
                                <select name="metodepelatihan_id" class="form-select modern-select" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach ($metodePelatihan as $metode)
                                        <option value="{{ $metode->id }}" {{ $usulan->metodepelatihan_id == $metode->id ? 'selected' : '' }}>
                                            {{ $metode->metode_pelatihan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-tags me-2"></i>
                                    Jenis Pelatihan
                                    <span class="required">*</span>
                                </label>
                                <select name="jenispelatihan_id" class="form-select modern-select" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach ($jenisPelatihan as $jenis)
                                        <option value="{{ $jenis->id }}" {{ $usulan->jenispelatihan_id == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis_pelatihan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Pelaksanaan Section -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="bi bi-calendar-event me-2"></i>
                        Detail Pelaksanaan
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-building me-2"></i>
                                    Penyelenggara Pelatihan
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="penyelenggara_pelatihan" class="form-control modern-input"
                                    value="{{ $usulan->penyelenggara_pelatihan }}" placeholder="Contoh: Lembaga Pelatihan ABC, Universitas XYZ" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-pin-map me-2"></i>
                                    Tempat Pelatihan
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="tempat_pelatihan" class="form-control modern-input"
                                    value="{{ $usulan->tempat_pelatihan }}" placeholder="Contoh: Jakarta, Bandung, Online Platform" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-calendar-plus me-2"></i>
                                    Tanggal Mulai
                                    <span class="required">*</span>
                                </label>
                                <input type="date" name="tanggal_mulai" class="form-control modern-input" 
                                    value="{{ \Carbon\Carbon::parse($usulan->tanggal_mulai)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Tanggal Selesai
                                    <span class="required">*</span>
                                </label>
                                <input type="date" name="tanggal_selesai" class="form-control modern-input"
                                    value="{{ \Carbon\Carbon::parse($usulan->tanggal_selesai)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biaya dan Dokumen Section -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="bi bi-currency-dollar me-2"></i>
                        Biaya dan Dokumen
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-cash me-2"></i>
                                    Estimasi Biaya
                                    <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-addon">Rp</span>
                                    <input type="number" name="estimasi_biaya" class="form-control modern-input"
                                        value="{{ $usulan->estimasi_biaya }}" min="0" step="1000" required>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Masukkan estimasi biaya dalam Rupiah (tanpa titik atau koma)
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    File Penawaran
                                    @if(!$usulan->file_penawaran)<span class="required">*</span>@endif
                                </label>
                                @if ($usulan->file_penawaran)
                                    <div class="current-file-info">
                                        <div class="file-preview">
                                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                                            <div class="file-details">
                                                <span class="file-name">File saat ini tersedia</span>
                                                <div class="file-actions">
                                                    <a href="{{ asset('storage/' . $usulan->file_penawaran) }}" target="_blank" class="btn btn-elegant btn-outline-primary btn-sm">
                                                        <i class="bi bi-eye me-1"></i>
                                                        Lihat File
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="file-upload-wrapper">
                                    <input type="file" name="file_penawaran" class="form-control modern-input file-input"
                                        accept=".pdf" id="file_penawaran" @if(!$usulan->file_penawaran) required @endif>
                                    <div class="file-upload-info">
                                        <i class="bi bi-cloud-upload text-muted"></i>
                                        <span class="file-upload-text">
                                            @if($usulan->file_penawaran)
                                                Upload file PDF baru (Opsional, Max: 10MB)
                                            @else
                                                Upload file PDF (Max: 10MB)
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @if($usulan->file_penawaran)
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Kosongkan jika tidak ingin mengubah file penawaran
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan Section -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="bi bi-chat-text me-2"></i>
                        Keterangan Tambahan
                    </h5>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-card-text me-2"></i>
                            Keterangan
                            <span class="required">*</span>
                        </label>
                        <textarea name="keterangan" class="form-control modern-textarea" rows="4"
                            placeholder="Tambahkan catatan, alasan, atau keterangan tambahan mengenai usulan pelatihan ini..." required>{{ $usulan->keterangan }}</textarea>
                        <small class="text-muted">
                            <i class="bi bi-lightbulb me-1"></i>
                            Jelaskan tujuan, manfaat, atau alasan mengapa pelatihan ini diperlukan
                        </small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-elegant btn-outline-secondary" onclick="window.history.back()">
                        <i class="bi bi-arrow-left me-2"></i>
                        Batal
                    </button>
                    <button type="button" class="btn btn-elegant btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        <i class="bi bi-save me-2"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
        
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modern-modal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">
                            <i class="bi bi-save me-2"></i>
                            Konfirmasi Perubahan Usulan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <div class="confirm-icon">
                                <i class="bi bi-question-circle"></i>
                            </div>
                        </div>
                        <p class="text-center mb-3">
                            Apakah Anda yakin ingin menyimpan perubahan usulan pelatihan ini?
                        </p>
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                <strong>Informasi:</strong> Setelah disimpan, status usulan akan kembali ke "Tersimpan" 
                                dan dapat diedit kembali sebelum dikirim.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-elegant btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </button>
                        <button type="submit" form="pelatihanForm" class="btn btn-elegant btn-primary">
                            <i class="bi bi-save me-2"></i>
                            Ya, Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Modal -->
        <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modern-modal">
                    @if (session('success'))
                        <div class="modal-header success-header">
                            <h5 class="modal-title" id="resultModalLabel">
                                <i class="bi bi-check-circle me-2"></i>Perubahan Berhasil Disimpan!
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="success-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h6 class="mt-3 text-success">{{ session('success') }}</h6>
                            <p class="text-muted mt-2">Usulan pelatihan telah berhasil diperbarui dengan data terbaru.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-success">
                                <i class="bi bi-list-ul me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    @elseif(session('error'))
                        <div class="modal-header error-header">
                            <h5 class="modal-title" id="resultModalLabel">
                                <i class="bi bi-exclamation-triangle me-2"></i>Gagal Menyimpan Perubahan!
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="error-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <h6 class="mt-3 text-danger">{{ session('error') }}</h6>
                            @if($errors->any())
                                <div class="alert alert-danger mt-3 text-start">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-elegant btn-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x me-2"></i>Tutup
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // File upload enhancement
            const fileInput = document.getElementById('file_penawaran');
            const fileUploadText = document.querySelector('.file-upload-text');
            
            if (fileInput && fileUploadText) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                        if (fileSize > 10) {
                            alert('Ukuran file terlalu besar. Maksimal 10MB.');
                            this.value = '';
                            fileUploadText.textContent = 'Upload file PDF baru (Opsional, Max: 10MB)';
                            return;
                        }
                        fileUploadText.textContent = `${file.name} (${fileSize} MB)`;
                    } else {
                        @if($usulan->file_penawaran)
                            fileUploadText.textContent = 'Upload file PDF baru (Opsional, Max: 10MB)';
                        @else
                            fileUploadText.textContent = 'Upload file PDF (Max: 10MB)';
                        @endif
                    }
                });
            }

            // Enhanced form validation
            const form = document.getElementById('pelatihanForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        const firstInvalid = form.querySelector('.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstInvalid.focus();
                        }
                    }
                });
            }

            // Currency formatting for biaya field
            const biayaInput = document.querySelector('input[name="estimasi_biaya"]');
            if (biayaInput) {
                biayaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                });
                
                biayaInput.addEventListener('blur', function(e) {
                    let value = parseInt(e.target.value);
                    if (!isNaN(value)) {
                        e.target.setAttribute('data-bs-toggle', 'tooltip');
                        e.target.setAttribute('title', 'Rp ' + value.toLocaleString('id-ID'));
                        new bootstrap.Tooltip(e.target);
                    }
                });
            }

            // Auto-show result modal if there's a session message
            @if (session('success') || session('error'))
                const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
                resultModal.show();

                // Auto-hide after 5 seconds with countdown for success
                @if (session('success'))
                    let countdown = 5;
                    const countdownInterval = setInterval(function() {
                        countdown--;
                        if (countdown <= 0) {
                            clearInterval(countdownInterval);
                            resultModal.hide();
                            
                            // Redirect after modal is hidden
                            setTimeout(function() {
                                window.location.href = "{{ route('pelatihan.usulan.index') }}";
                            }, 500);
                        }
                    }, 1000);

                    // Clear countdown if user manually closes modal
                    document.getElementById('resultModal').addEventListener('hidden.bs.modal', function() {
                        clearInterval(countdownInterval);
                        window.location.href = "{{ route('pelatihan.usulan.index') }}";
                    });
                @endif
            @endif
        });
    </script>
@section('additional-css')
    <style>
        :root {
            /* Use global soft color palette */
            --primary-color: var(--primary-soft);
            --primary-light: var(--primary-soft);
            --primary-dark: var(--primary-hover);
            --secondary-color: var(--light-soft);
            --accent-color: var(--info-soft);
            --success-color: var(--success-soft);
            --warning-color: var(--warning-soft);
            --danger-color: var(--danger-soft);
            --text-primary: var(--dark-soft);
            --text-secondary: var(--secondary-soft);
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --bg-primary: #ffffff;
            --bg-secondary: var(--light-soft);
            --shadow-sm: 0 2px 4px rgba(148, 163, 184, 0.1);
            --shadow-md: 0 4px 12px rgba(148, 163, 184, 0.15);
            --shadow-lg: 0 8px 24px rgba(148, 163, 184, 0.2);
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            padding-top: 3rem;
        }

        .modern-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Hero Header */
        .hero-header {
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-breadcrumb .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .hero-breadcrumb .breadcrumb-item {
            font-size: 0.875rem;
        }

        .hero-breadcrumb .breadcrumb-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
        }

        .hero-breadcrumb .breadcrumb-link:hover {
            color: white;
        }

        .hero-breadcrumb .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin: 0;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #e8eaf6 100%);
            border: 1px solid var(--primary-soft);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            background: var(--primary-soft);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .info-content h6 {
            color: var(--primary-hover);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: var(--text-secondary);
            margin: 0;
        }

        .status-highlight {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-highlight.status-saved {
            background: var(--success-soft);
            color: #2e7d32;
        }

        /* Main Card */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--border-color);
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin: 0;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .required {
            color: var(--danger-color);
            margin-left: 0.25rem;
        }

        .modern-input, .modern-select, .modern-textarea {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--bg-primary);
        }

        .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
            outline: none;
        }

        .modern-input.is-invalid, .modern-select.is-invalid, .modern-textarea.is-invalid {
            border-color: var(--danger-color);
        }

        .modern-input-addon {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-right: none;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Current File Info */
        .current-file-info {
            margin-bottom: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--info-soft);
        }

        .file-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-preview i {
            font-size: 2rem;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            color: var(--text-primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .file-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-info {
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 2rem;
            text-align: center;
            background: var(--bg-primary);
            transition: var(--transition);
        }

        .file-upload-info:hover {
            border-color: var(--primary-soft);
            background: rgba(139, 157, 195, 0.02);
        }

        .file-upload-info i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Form Help */
        .form-help {
            margin-top: 0.75rem;
            padding: 1rem;
            background: linear-gradient(135deg, #e1f5fe 0%, #e3f2fd 100%);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--info-soft);
        }

        .help-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .help-text {
            color: var(--text-secondary);
            margin: 0;
            flex: 1;
        }

        /* Buttons */
        .btn-elegant {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid transparent;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-elegant.btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-soft);
        }

        .btn-elegant.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-soft) 100%);
            color: white;
        }

        .btn-elegant.btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-secondary:hover {
            background: var(--bg-secondary);
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        .btn-elegant.btn-outline-primary {
            color: var(--primary-soft);
            border-color: var(--primary-soft);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-primary:hover {
            background: var(--primary-soft);
            color: white;
        }

        .btn-elegant.btn-success {
            background: var(--gradient-success);
            color: white;
            border-color: var(--success-soft);
        }

        .btn-elegant.btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            margin-top: 2rem;
        }

        /* Modern Modal */
        .modern-modal .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modern-modal .modal-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
        }

        .modern-modal .modal-header.success-header {
            background: var(--gradient-success);
        }

        .modern-modal .modal-header.error-header {
            background: var(--gradient-danger);
        }

        .modern-modal .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .modern-modal .modal-footer {
            padding: 1.5rem 2rem;
            border: none;
            background: var(--bg-secondary);
        }

        .confirm-icon, .success-icon, .error-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2.5rem;
        }

        .confirm-icon {
            background: rgba(139, 157, 195, 0.1);
            color: var(--primary-soft);
        }

        .success-icon {
            background: rgba(165, 214, 167, 0.1);
            color: var(--success-soft);
        }

        .error-icon {
            background: rgba(239, 154, 154, 0.1);
            color: var(--danger-soft);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-card {
                padding: 1.5rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .help-content {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .file-preview {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Select2 Enhancement */
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.75rem + 4px);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
        }

        .select2-container--bootstrap4 .select2-selection--single:focus {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.5rem;
            padding-left: 1rem;
        }
    </style>
@endsection
