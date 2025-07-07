@extends('layouts.pelatihan.app')

@section('title', 'Buat Usulan Nomenklatur Pelatihan')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-lightbulb-fill me-3"></i>
                        Buat Usulan Nomenklatur
                    </h1>
                    <p class="hero-subtitle">Ajukan usulan nama pelatihan baru untuk pengembangan kompetensi ASN</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.nomenklatur') }}" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Information Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div class="info-content">
                <h6 class="info-title">Panduan Pengisian Usulan</h6>
                <p class="info-text">
                    Pastikan nama pelatihan yang diusulkan <span class="status-highlight status-saved">spesifik</span> dan 
                    <span class="status-highlight status-processed">sesuai kebutuhan</span> pengembangan kompetensi ASN.
                    Usulan akan ditinjau oleh tim administrasi.
                </p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="main-card">
            <!-- Alert Section -->
            @if(session('success'))
                <div class="alert-section">
                    <div class="alert alert-success" id="successAlert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-section">
                    <div class="alert alert-danger" id="errorAlert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <div class="error-list">
                            <strong>Terdapat kesalahan pada pengisian form:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <h3 class="form-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Formulir Usulan Nomenklatur
                    </h3>
                    <p class="form-subtitle">Lengkapi informasi usulan pelatihan dengan benar dan lengkap</p>
                </div>

                <form action="{{ route('pelatihan.store-nomenklatur') }}" method="POST" id="usulForm" class="modern-form">
                    @csrf

                    <div class="form-grid">
                        <!-- Nama Pelatihan Field -->
                        <div class="form-group">
                            <label for="nama_pelatihan" class="form-label">
                                <i class="bi bi-bookmark me-1"></i>
                                Nama Pelatihan
                                <span class="required-mark">*</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       name="nama_pelatihan" 
                                       id="nama_pelatihan" 
                                       class="form-control modern-input @error('nama_pelatihan') is-invalid @enderror" 
                                       required
                                       placeholder="Contoh: Pelatihan Manajemen Proyek untuk ASN"
                                       value="{{ old('nama_pelatihan') }}"
                                       maxlength="255">
                                <div class="input-icon">
                                    <i class="bi bi-bookmark-fill"></i>
                                </div>
                            </div>
                            <div class="form-help">
                                <i class="bi bi-info-circle me-1"></i>
                                Masukkan nama pelatihan yang spesifik dan jelas
                            </div>
                            @error('nama_pelatihan')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Jenis Pelatihan Field -->
                        <div class="form-group">
                            <label for="jenispelatihan_id" class="form-label">
                                <i class="bi bi-tags me-1"></i>
                                Jenis Pelatihan
                                <span class="required-mark">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select name="jenispelatihan_id" 
                                        id="jenispelatihan_id"
                                        class="form-select modern-select @error('jenispelatihan_id') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Jenis Pelatihan --</option>
                                    @foreach ($jenisPelatihan as $jenis)
                                        <option value="{{ $jenis->id }}" 
                                                {{ old('jenispelatihan_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis_pelatihan }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="select-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="form-help">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih kategori jenis pelatihan yang sesuai
                            </div>
                            @error('jenispelatihan_id')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="nip" value="{{ auth()->user()->nip }}">
                    <input type="hidden" name="status" value="proses">

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-elegant btn-outline-secondary" onclick="goBack()">
                                <i class="bi bi-arrow-left me-2"></i>
                                <span>Batal</span>
                            </button>
                            <button type="submit" class="btn btn-elegant btn-primary" id="submitBtn">
                                <i class="bi bi-send-check me-2"></i>
                                <span>Kirim Usulan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if(session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modern-modal">
                    <div class="modal-header modal-header-success">
                        <h5 class="modal-title" id="successModalLabel">
                            <i class="bi bi-check-circle me-2"></i>
                            Usulan Berhasil Dikirim!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="success-content">
                            <div class="success-icon">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <h6 class="success-title">Terima kasih!</h6>
                            <p class="success-text">{{ session('success') }}</p>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Usulan Anda akan ditinjau oleh tim administrasi dalam 1-3 hari kerja.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-elegant btn-success" data-bs-dismiss="modal">
                            <i class="bi bi-check me-1"></i>
                            Mengerti
                        </button>
                        <a href="{{ route('pelatihan.nomenklatur') }}" class="btn btn-elegant btn-outline-secondary">
                            <i class="bi bi-list me-1"></i>
                            Lihat Semua Usulan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('additional-css')
    <style>
        :root {
            /* Global soft color palette - matching hasil-registrasi.blade.php */
            --primary-color: #8b9dc3;
            --primary-light: #dfe3ee;
            --primary-hover: #748dc9;
            --secondary-color: #64748b;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --shadow-sm: 0 2px 4px rgba(148, 163, 184, 0.1);
            --shadow-md: 0 4px 12px rgba(148, 163, 184, 0.15);
            --shadow-lg: 0 8px 24px rgba(148, 163, 184, 0.2);
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--bg-secondary) 0%, #e2e8f0 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        .modern-container {
            max-width: 1400px;
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
            border: 1px solid var(--primary-color);
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
            background: var(--primary-color);
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
            margin: 0 0.25rem;
        }

        .status-highlight.status-saved {
            background: rgba(99, 102, 241, 0.15);
            color: #4c1d95;
        }

        .status-highlight.status-processed {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        /* Main Card */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* Alert Section */
        .alert-section {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .alert {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 1rem 1.25rem;
            margin: 0;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            position: relative;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-info {
            background: rgba(99, 102, 241, 0.1);
            color: #4c1d95;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .error-list ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        /* Form Section */
        .form-section {
            padding: 2rem;
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-subtitle {
            color: var(--text-secondary);
            margin: 0;
        }

        .modern-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .required-mark {
            color: var(--danger-color);
            margin-left: 0.25rem;
            font-weight: 700;
        }

        .input-wrapper,
        .select-wrapper {
            position: relative;
            transition: var(--transition);
        }

        .modern-input,
        .modern-select {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--bg-primary);
        }

        .modern-select {
            padding-right: 3rem;
            padding-left: 1rem;
            cursor: pointer;
            appearance: none;
        }

        .modern-input:focus,
        .modern-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
            outline: none;
            transform: translateY(-1px);
        }

        .modern-input.is-invalid,
        .modern-select.is-invalid {
            border-color: var(--danger-color);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .modern-input.is-valid,
        .modern-select.is-valid {
            border-color: var(--success-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            z-index: 2;
            transition: var(--transition);
        }

        .modern-input:focus + .input-icon {
            color: var(--primary-color);
        }

        .select-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            z-index: 2;
            transition: var(--transition);
        }

        .modern-select:focus + .select-icon {
            color: var(--primary-color);
            transform: translateY(-50%) rotate(180deg);
        }

        .form-help {
            margin-top: 0.5rem;
            font-size: 0.8125rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.8125rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-info {
            text-align: center;
        }

        /* Buttons */
        .btn-elegant {
            font-weight: 600;
            padding: 0.875rem 1.5rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid transparent;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-elegant.btn-outline-light {
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-elegant.btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
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
            transform: translateY(-2px);
        }

        .btn-elegant.btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-elegant.btn-primary:hover:not(:disabled) {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-elegant.btn-success {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .btn-elegant.btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Modals */
        .modern-modal {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modern-modal .modal-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .modern-modal .modal-header.modal-header-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .modern-modal .modal-footer {
            background: var(--bg-secondary);
            border: none;
            padding: 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .success-content {
            text-align: center;
        }

        .success-icon {
            margin-bottom: 1rem;
        }

        .success-icon i {
            font-size: 3rem;
        }

        .success-title {
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .success-text {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        /* Character Counter */
        .character-counter {
            font-size: 0.8125rem;
            color: var(--text-muted);
            text-align: right;
            margin-top: 0.25rem;
        }

        .character-counter.warning {
            color: var(--warning-color);
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

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

            .info-card {
                flex-direction: column;
                text-align: center;
            }

            .form-section {
                padding: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .modern-modal .modal-body,
            .modern-modal .modal-footer {
                padding: 1.5rem;
            }

            .modern-modal .modal-footer {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-header {
                margin-bottom: 1.5rem;
            }

            .form-title {
                font-size: 1.25rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .modern-input,
            .modern-select {
                padding: 0.875rem 0.875rem 0.875rem 2.5rem;
            }

            .btn-elegant {
                padding: 0.75rem 1.25rem;
                font-size: 0.8125rem;
            }
        }

        /* Loading and Animation States */
        .spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Focus states for accessibility */
        .btn-elegant:focus,
        .modern-input:focus,
        .modern-select:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Success modal animations */
        .success-icon i {
            animation: successPulse 0.6s ease-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-show success modal if session success exists
            @if(session('success'))
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Auto-hide after 10 seconds
                setTimeout(() => {
                    successModal.hide();
                }, 10000);
            @endif

            // Auto-hide alerts
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 300);
                }, 5000);
            }

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        errorAlert.style.display = 'none';
                    }, 300);
                }, 8000);
            }

            // Form submission handling
            const usulForm = document.getElementById('usulForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (usulForm && submitBtn) {
                usulForm.addEventListener('submit', function(e) {
                    // Add loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2 spin"></i><span>Mengirim...</span>';
                    
                    // Prevent double submission
                    setTimeout(() => {
                        if (!submitBtn.disabled) return;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-send-check me-2"></i><span>Kirim Usulan</span>';
                    }, 10000);
                });
            }

            // Form validation and character counting
            const namaInput = document.getElementById('nama_pelatihan');
            if (namaInput) {
                // Character counter
                const maxLength = namaInput.getAttribute('maxlength');
                const wrapper = namaInput.closest('.form-group');
                
                if (maxLength && wrapper) {
                    const counter = document.createElement('div');
                    counter.className = 'character-counter';
                    counter.innerHTML = `<span class="current">0</span>/<span class="max">${maxLength}</span> karakter`;
                    wrapper.appendChild(counter);

                    namaInput.addEventListener('input', function() {
                        const current = this.value.length;
                        counter.querySelector('.current').textContent = current;
                        
                        if (current > maxLength * 0.9) {
                            counter.classList.add('warning');
                        } else {
                            counter.classList.remove('warning');
                        }
                    });

                    // Initial count
                    const currentLength = namaInput.value.length;
                    counter.querySelector('.current').textContent = currentLength;
                }

                // Real-time validation
                namaInput.addEventListener('blur', function() {
                    if (this.value.trim().length < 10) {
                        this.classList.add('is-invalid');
                        showFieldError(this, 'Nama pelatihan minimal 10 karakter');
                    } else {
                        this.classList.remove('is-invalid');
                        hideFieldError(this);
                    }
                });
            }

            // Enhanced select styling
            const selectElement = document.getElementById('jenispelatihan_id');
            if (selectElement) {
                selectElement.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        hideFieldError(this);
                    }
                });
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + Enter to submit form
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    if (usulForm && !submitBtn.disabled) {
                        usulForm.requestSubmit();
                    }
                }
                
                // Escape to go back
                if (e.key === 'Escape') {
                    goBack();
                }
            });

            // Enhanced hover effects for form elements
            const formInputs = document.querySelectorAll('.modern-input, .modern-select');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.input-wrapper, .select-wrapper').style.transform = 'translateY(-1px)';
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.input-wrapper, .select-wrapper').style.transform = 'translateY(0)';
                });
            });
        });

        // Go back function
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.host)) {
                window.history.back();
            } else {
                window.location.href = '{{ route("pelatihan.nomenklatur") }}';
            }
        }

        // Field error helpers
        function showFieldError(field, message) {
            hideFieldError(field);
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback d-block';
            errorDiv.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
            field.parentNode.appendChild(errorDiv);
        }

        function hideFieldError(field) {
            const existingError = field.parentNode.querySelector('.invalid-feedback');
            if (existingError) {
                existingError.remove();
            }
        }

        // Clear draft on successful submission
        @if(session('success'))
            localStorage.removeItem('draft_usulan_nomenklatur');
        @endif
    </script>
@endsection