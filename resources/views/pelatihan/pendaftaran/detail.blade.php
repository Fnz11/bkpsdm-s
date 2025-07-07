@extends('layouts.pelatihan.app')

@section('title', 'Detail Hasil Pendaftaran')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-file-text-fill me-3"></i>
                        Detail Hasil Pendaftaran
                    </h1>
                    <p class="hero-subtitle">Informasi lengkap pendaftaran dan status pelatihan Anda</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.pendaftaran') }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>
        </div>

        @php
            $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
            $isUsulan = !is_null($pendaftaran->usulan);
            $user = $pendaftaran->user;
        @endphp

        <!-- Status Overview Card -->
        <div class="status-overview-card">
            <div class="status-header">
                <h5 class="status-title">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Status Pendaftaran
                </h5>
            </div>
            <div class="status-grid">
                <div class="status-item">
                    <div class="status-icon verification">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="status-content">
                        <span class="status-label">Verifikasi</span>
                        @php
                            $verificationClass = match($pendaftaran->status_verifikasi) {
                                'tersimpan' => 'status-saved',
                                'terkirim' => 'status-sent', 
                                'diterima' => 'status-accepted',
                                'tercetak' => 'status-processed',
                                default => 'status-rejected'
                            };
                        @endphp
                        <span class="status-badge {{ $verificationClass }}">
                            {{ ucfirst($pendaftaran->status_verifikasi) }}
                        </span>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-icon participant">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="status-content">
                        <span class="status-label">Peserta</span>
                        @php
                            $participantClass = match($pendaftaran->status_peserta) {
                                'calon_peserta' => 'participant-candidate',
                                'peserta' => 'participant-active',
                                'alumni' => 'participant-alumni',
                                default => 'participant-unknown'
                            };
                        @endphp
                        <span class="participant-badge {{ $participantClass }}">
                            {{ ucwords(str_replace('_', ' ', $pendaftaran->status_peserta)) }}
                        </span>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-icon date">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="status-content">
                        <span class="status-label">Tanggal Daftar</span>
                        <span class="status-value">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Cards -->
        <div class="content-grid">
            <!-- Training Information Card -->
            <div class="info-card-detail">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="bi bi-mortarboard-fill me-2"></i>
                        Informasi Pelatihan
                    </h5>
                    <span class="card-badge {{ $isUsulan ? 'badge-usulan' : 'badge-tersedia' }}">
                        {{ $isUsulan ? 'Usulan Mandiri' : 'Pelatihan Tersedia' }}
                    </span>
                </div>
                <div class="card-body-modern">
                    @if (!$isUsulan && $pelatihan->gambar)
                        <div class="training-image-container">
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" 
                                 class="training-image" 
                                 alt="Gambar Pelatihan"
                                 loading="lazy">
                        </div>
                    @endif
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-bookmark-fill me-2"></i>
                                Nama Pelatihan
                            </span>
                            <span class="info-value">{{ $pelatihan->nama_pelatihan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-tag-fill me-2"></i>
                                Jenis
                            </span>
                            <span class="info-value">{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-gear-fill me-2"></i>
                                Metode
                            </span>
                            <span class="info-value">{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-calendar2-check-fill me-2"></i>
                                Pelaksanaan
                            </span>
                            <span class="info-value">{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-building-fill me-2"></i>
                                Penyelenggara
                            </span>
                            <span class="info-value">{{ $pelatihan->penyelenggara_pelatihan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                Tempat
                            </span>
                            <span class="info-value">{{ $pelatihan->tempat_pelatihan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule & Cost Information -->
            <div class="info-card-detail">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="bi bi-calendar-range-fill me-2"></i>
                        Jadwal & Biaya
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="schedule-section">
                        <div class="schedule-item">
                            <i class="bi bi-calendar-date schedule-icon"></i>
                            <div class="schedule-info">
                                <span class="schedule-label">Periode Pelaksanaan</span>
                                <span class="schedule-value">
                                    {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }} 
                                    s.d. 
                                    {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cost-section">
                        @if ($isUsulan)
                            <div class="cost-item">
                                <span class="cost-label">
                                    <i class="bi bi-calculator me-2"></i>
                                    Estimasi Biaya
                                </span>
                                <span class="cost-value estimated">
                                    Rp {{ number_format($pelatihan->estimasi_biaya ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="cost-item">
                                <span class="cost-label">
                                    <i class="bi bi-cash-coin me-2"></i>
                                    Realisasi Biaya
                                </span>
                                <span class="cost-value realized">
                                    Rp {{ number_format($pelatihan->realisasi_biaya ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="cost-item">
                                <span class="cost-label">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    Biaya Pelatihan
                                </span>
                                <span class="cost-value total">
                                    Rp {{ number_format($pelatihan->biaya ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($isUsulan && $pelatihan->file_penawaran)
                <!-- File Attachment Card -->
                <div class="info-card-detail">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">
                            <i class="bi bi-paperclip me-2"></i>
                            File Lampiran
                        </h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="file-attachment">
                            <div class="file-icon">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                            <div class="file-info">
                                <span class="file-name">File Penawaran</span>
                                <span class="file-description">Dokumen penawaran pelatihan</span>
                            </div>
                            <a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}" 
                               target="_blank" 
                               class="btn btn-elegant btn-outline-primary btn-sm">
                                <i class="bi bi-download me-1"></i>
                                Unduh
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            <div class="info-card-detail">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="additional-info">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="bi bi-chat-text-fill me-2"></i>
                                Keterangan
                            </span>
                            <span class="info-value">{{ $pendaftaran->keterangan ?? 'Tidak ada keterangan tambahan' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

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

        /* Status Overview Card */
        .status-overview-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .status-header {
            margin-bottom: 1.5rem;
        }

        .status-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
        }

        .status-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .status-icon.verification {
            background: var(--primary-soft);
        }

        .status-icon.participant {
            background: var(--success-soft);
        }

        .status-icon.date {
            background: var(--info-soft);
        }

        .status-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .status-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .status-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 1rem;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-saved {
            background: rgba(148, 163, 184, 0.15);
            color: #64748b;
        }

        .status-sent {
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
        }

        .status-accepted {
            background: rgba(34, 197, 94, 0.15);
            color: #16a34a;
        }

        .status-processed {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        /* Participant Badges */
        .participant-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 1rem;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .participant-candidate {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
        }

        .participant-active {
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
        }

        .participant-alumni {
            background: rgba(168, 85, 247, 0.15);
            color: #9333ea;
        }

        .participant-unknown {
            background: rgba(148, 163, 184, 0.15);
            color: #64748b;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }

        /* Info Cards */
        .info-card-detail {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
        }

        .info-card-detail:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .card-header-modern {
            background: var(--bg-secondary);
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-modern {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-usulan {
            background: var(--primary-soft);
            color: white;
        }

        .badge-tersedia {
            background: var(--success-soft);
            color: white;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        /* Training Image */
        .training-image-container {
            margin-bottom: 1.5rem;
        }

        .training-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow-sm);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
        }

        .info-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-primary);
            word-break: break-word;
        }

        /* Schedule Section */
        .schedule-section {
            margin-bottom: 1.5rem;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
        }

        .schedule-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            background: var(--info-soft);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .schedule-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .schedule-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Cost Section */
        .cost-section {
            display: grid;
            gap: 1rem;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
        }

        .cost-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .cost-value {
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Familjen Grotesk', sans-serif;
        }

        .cost-value.estimated {
            color: var(--warning-color);
        }

        .cost-value.realized {
            color: var(--success-color);
        }

        .cost-value.total {
            color: var(--primary-color);
        }

        /* File Attachment */
        .file-attachment {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
        }

        .file-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--border-radius-sm);
            background: var(--primary-soft);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .file-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .file-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .file-description {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Additional Info */
        .additional-info {
            display: grid;
            gap: 1rem;
        }

        /* Buttons */
        .btn-elegant {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid transparent;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 0.875rem;
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
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-outline-primary {
            color: var(--primary-soft);
            border-color: var(--primary-soft);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-primary:hover {
            background: var(--primary-soft);
            border-color: var(--primary-soft);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .status-grid {
                grid-template-columns: 1fr;
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

            .status-overview-card,
            .card-body-modern {
                padding: 1.5rem;
            }

            .status-item {
                padding: 0.75rem;
            }

            .cost-item,
            .file-attachment,
            .schedule-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .cost-item {
                align-items: stretch;
            }

            .cost-label,
            .cost-value {
                text-align: left;
            }
        }

        /* CSS Variables (should match global palette) */
        :root {
            --primary-soft: #8b9dc3;
            --primary-hover: #7289b0;
            --success-soft: #a3d977;
            --warning-soft: #f5d76e;
            --danger-soft: #f87171;
            --info-soft: #7dd3fc;
            --light-soft: #f8fafc;
            --secondary-soft: #94a3b8;
            --dark-soft: #334155;
            --gradient-primary: linear-gradient(135deg, #8b9dc3 0%, #7289b0 100%);
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

            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading state to file download links
            document.querySelectorAll('a[href*="storage"]').forEach(link => {
                link.addEventListener('click', function() {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i>Mengunduh...';
                    this.style.pointerEvents = 'none';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                });
            });

            // Add copy to clipboard functionality for cost values
            document.querySelectorAll('.cost-value').forEach(element => {
                element.style.cursor = 'pointer';
                element.title = 'Klik untuk menyalin';
                
                element.addEventListener('click', function() {
                    const text = this.textContent.replace(/[^\d]/g, '');
                    navigator.clipboard.writeText(text).then(() => {
                        // Show feedback
                        const originalText = this.textContent;
                        this.textContent = 'Tersalin!';
                        setTimeout(() => {
                            this.textContent = originalText;
                        }, 1000);
                    });
                });
            });
        });
    </script>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
    @endsection
