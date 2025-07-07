@extends('layouts.pelatihan.app')

@section('title', 'Detail Usulan Pelatihan Mandiri')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="breadcrumb-nav">
                        <a href="{{ route('pelatihan.usulan.index') }}" class="breadcrumb-link">
                            <i class="bi bi-arrow-left me-2"></i>
                            Usulan Pelatihan
                        </a>
                        <i class="bi bi-chevron-right mx-2"></i>
                        <span class="breadcrumb-current">Detail Usulan</span>
                    </div>
                    <h1 class="hero-title">
                        <i class="bi bi-file-text-fill me-3"></i>
                        Detail Usulan Pelatihan
                    </h1>
                    <p class="hero-subtitle">Informasi lengkap mengenai usulan pelatihan mandiri</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                    @if ($pendaftaran->status_verifikasi === 'tersimpan')
                        <a href="{{ route('pelatihan.usulan.edit', $pendaftaran->id) }}"
                            class="btn btn-elegant btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>
                            <span>Edit Usulan</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @php
            $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
            $isUsulan = !is_null($pendaftaran->usulan);
            $user = $pendaftaran->user;
        @endphp

        <!-- Status Information Card -->
        <div class="status-overview-card">
            <div class="status-grid">
                <div class="status-item">
                    <div class="status-icon status-{{ $pendaftaran->status_verifikasi }}">
                        @switch($pendaftaran->status_verifikasi)
                            @case('tersimpan')
                                <i class="bi bi-save-fill"></i>
                            @break

                            @case('terkirim')
                                <i class="bi bi-send-fill"></i>
                            @break

                            @case('diterima')
                                <i class="bi bi-check-circle-fill"></i>
                            @break

                            @case('tercetak')
                                <i class="bi bi-printer-fill"></i>
                            @break

                            @default
                                <i class="bi bi-x-circle-fill"></i>
                        @endswitch
                    </div>
                    <div class="status-content">
                        <h6 class="status-label">Status Verifikasi</h6>
                        <span class="status-value">{{ ucfirst($pendaftaran->status_verifikasi) }}</span>
                    </div>
                </div>

                <div class="status-item">
                    <div class="status-icon status-peserta">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="status-content">
                        <h6 class="status-label">Status Peserta</h6>
                        <span class="status-value">{{ ucwords(str_replace('_', ' ', $pendaftaran->status_peserta)) }}</span>
                    </div>
                </div>

                <div class="status-item">
                    <div class="status-icon status-date">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div class="status-content">
                        <h6 class="status-label">Tanggal Pendaftaran</h6>
                        <span
                            class="status-value">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Information Cards -->
        <div class="info-cards-grid">
            <!-- Training Information Card -->
            <div class="info-card main-info">
                <div class="card-header-custom">
                    <div class="card-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="card-title-section">
                        <h5 class="card-title">Informasi Pelatihan</h5>
                        <p class="card-subtitle">Detail lengkap mengenai pelatihan yang diusulkan</p>
                    </div>
                </div>

                @if (!$isUsulan && $pelatihan->gambar)
                    <div class="training-image">
                        <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="img-fluid" alt="Gambar Pelatihan">
                        <div class="image-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </div>
                @endif

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-bookmark-fill me-2"></i>
                            Nama Pelatihan
                        </div>
                        <div class="info-value highlight">{{ $pelatihan->nama_pelatihan ?? 'Tidak tersedia' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-tag-fill me-2"></i>
                            Jenis Pelatihan
                        </div>
                        <div class="info-value">
                            <span class="meta-badge badge-type">
                                {{ $pelatihan->jenispelatihan->jenis_pelatihan ?? 'Tidak tersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-gear-fill me-2"></i>
                            Metode Pelatihan
                        </div>
                        <div class="info-value">
                            <span class="meta-badge badge-method">
                                {{ $pelatihan->metodepelatihan->metode_pelatihan ?? 'Tidak tersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-calendar2-check-fill me-2"></i>
                            Pelaksanaan
                        </div>
                        <div class="info-value">
                            <span class="meta-badge badge-implementation">
                                {{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? 'Tidak tersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-building-fill me-2"></i>
                            Penyelenggara
                        </div>
                        <div class="info-value">{{ $pelatihan->penyelenggara_pelatihan ?? 'Tidak tersedia' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Tempat Pelatihan
                        </div>
                        <div class="info-value">{{ $pelatihan->tempat_pelatihan ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>
            </div>

            <!-- Schedule & Cost Information -->
            <div class="info-cards-secondary">
                <!-- Schedule Card -->
                <div class="info-card schedule-card">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="bi bi-calendar-range-fill"></i>
                        </div>
                        <div class="card-title-section">
                            <h6 class="card-title">Jadwal Pelatihan</h6>
                            <p class="card-subtitle">Waktu pelaksanaan</p>
                        </div>
                    </div>

                    <div class="schedule-info">
                        <div class="schedule-item">
                            <div class="schedule-icon start">
                                <i class="bi bi-play-circle-fill"></i>
                            </div>
                            <div class="schedule-details">
                                <span class="schedule-label">Tanggal Mulai</span>
                                <span
                                    class="schedule-date">{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="schedule-divider">
                            <div class="divider-line"></div>
                            <span class="divider-text">s.d.</span>
                            <div class="divider-line"></div>
                        </div>

                        <div class="schedule-item">
                            <div class="schedule-icon end">
                                <i class="bi bi-stop-circle-fill"></i>
                            </div>
                            <div class="schedule-details">
                                <span class="schedule-label">Tanggal Selesai</span>
                                <span
                                    class="schedule-date">{{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="duration-info">
                            <i class="bi bi-clock-fill me-2"></i>
                            <span>{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($pelatihan->tanggal_selesai)) + 1 }}
                                hari pelatihan</span>
                        </div>
                    </div>
                </div>

                <!-- Cost Card -->
                <div class="info-card cost-card">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="card-title-section">
                            <h6 class="card-title">Informasi Biaya</h6>
                            <p class="card-subtitle">Detail pembiayaan</p>
                        </div>
                    </div>

                    <div class="cost-info">
                        @if ($isUsulan)
                            <div class="cost-item">
                                <div class="cost-label">
                                    <i class="bi bi-calculator me-2"></i>
                                    Estimasi Biaya
                                </div>
                                <div class="cost-value estimate">
                                    Rp {{ number_format($pelatihan->estimasi_biaya ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="cost-item">
                                <div class="cost-label">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Realisasi Biaya
                                </div>
                                <div class="cost-value realization">
                                    Rp {{ number_format($pelatihan->realisasi_biaya ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        @else
                            <div class="cost-item">
                                <div class="cost-label">
                                    <i class="bi bi-tag me-2"></i>
                                    Biaya Pelatihan
                                </div>
                                <div class="cost-value total">
                                    Rp {{ number_format($pelatihan->biaya ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        @if ($isUsulan && $pelatihan->file_penawaran)
                            <div class="file-attachment">
                                <div class="attachment-icon">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                                <div class="attachment-info">
                                    <span class="attachment-label">File Penawaran</span>
                                    <a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}" target="_blank"
                                        class="attachment-link">
                                        <i class="bi bi-download me-1"></i>
                                        Unduh File
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        @if ($pendaftaran->keterangan)
            <div class="additional-info-card">
                <div class="card-header-custom">
                    <div class="card-icon">
                        <i class="bi bi-chat-text-fill"></i>
                    </div>
                    <div class="card-title-section">
                        <h6 class="card-title">Keterangan Tambahan</h6>
                        <p class="card-subtitle">Informasi dan catatan lainnya</p>
                    </div>
                </div>
                <div class="additional-content">
                    <p class="keterangan-text">{{ $pendaftaran->keterangan }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('additional-css')
    <style>
        /* Base Styling */
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: var(--dark-soft);
            line-height: 1.7;
            min-height: 100vh;
        }

        /* Modern Container */
        .modern-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Hero Header */
        .hero-header {
            background: var(--gradient-primary);
            border-radius: var(--border-radius-lg);
            padding: 3rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .breadcrumb-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .breadcrumb-link:hover {
            color: white;
        }

        .breadcrumb-current {
            color: rgba(255, 255, 255, 0.6);
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        /* Elegant Buttons */
        .btn-elegant {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-elegant.btn-primary {
            background: white;
            color: var(--primary-soft);
        }

        .btn-elegant.btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-elegant:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Status Overview Card */
        .status-overview-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .status-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .status-tersimpan {
            background: var(--gradient-secondary);
        }

        .status-terkirim {
            background: var(--gradient-primary);
        }

        .status-diterima {
            background: var(--gradient-success);
        }

        .status-tercetak {
            background: var(--gradient-warning);
        }

        .status-ditolak {
            background: var(--gradient-danger);
        }

        .status-peserta {
            background: var(--gradient-info);
        }

        .status-date {
            background: var(--gradient-warning);
        }

        .status-content {
            flex: 1;
        }

        .status-label {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            margin: 0 0 0.25rem 0;
            font-weight: 500;
        }

        .status-value {
            font-size: 1.1rem;
            color: var(--dark-soft);
            font-weight: 600;
        }

        /* Info Cards Grid */
        .info-cards-grid {
            display: grid;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-cards-secondary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* Info Card */
        .info-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
            background: var(--gradient-primary);
        }

        .card-title-section .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            color: var(--dark-soft);
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            margin: 0.25rem 0 0 0;
        }

        /* Training Image */
        .training-image {
            position: relative;
            margin: 2rem;
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .training-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 2rem;
        }

        .training-image:hover .image-overlay {
            opacity: 1;
        }

        /* Info Grid */
        .info-grid {
            padding: 2rem;
            display: grid;
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark-soft);
            font-weight: 500;
        }

        .info-value.highlight {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-soft);
        }

        /* Meta Badges */
        .meta-badge {
            padding: 0.4rem 0.8rem;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-type {
            background: rgba(139, 157, 195, 0.1);
            color: var(--primary-soft);
        }

        .badge-method {
            background: rgba(165, 214, 167, 0.1);
            color: #059669;
        }

        .badge-implementation {
            background: rgba(179, 229, 252, 0.1);
            color: #0891b2;
        }

        /* Schedule Card */
        .schedule-info {
            padding: 2rem;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .schedule-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            flex-shrink: 0;
        }

        .schedule-icon.start {
            background: var(--gradient-success);
        }

        .schedule-icon.end {
            background: var(--gradient-danger);
        }

        .schedule-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .schedule-label {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            font-weight: 500;
        }

        .schedule-date {
            font-size: 1.1rem;
            color: var(--dark-soft);
            font-weight: 600;
        }

        .schedule-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem 0;
        }

        .divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, var(--primary-soft), transparent);
        }

        .divider-text {
            color: var(--secondary-soft);
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            background: #f8fafc;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .duration-info {
            background: rgba(139, 157, 195, 0.1);
            color: var(--primary-soft);
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        /* Cost Card */
        .cost-info {
            padding: 2rem;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .cost-item:last-child {
            border-bottom: none;
        }

        .cost-label {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .cost-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .cost-value.estimate {
            color: var(--warning-soft);
        }

        .cost-value.realization {
            color: var(--success-soft);
        }

        .cost-value.total {
            color: var(--primary-soft);
        }

        /* File Attachment */
        .file-attachment {
            background: rgba(179, 229, 252, 0.1);
            border-radius: var(--border-radius-sm);
            padding: 1rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .attachment-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-info);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .attachment-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .attachment-label {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            font-weight: 500;
        }

        .attachment-link {
            color: #0891b2;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .attachment-link:hover {
            color: #0e7490;
        }

        /* Additional Info Card */
        .additional-info-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .additional-content {
            padding: 2rem;
        }

        .keterangan-text {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--dark-soft);
            margin: 0;
            padding: 1rem;
            background: rgba(139, 157, 195, 0.05);
            border-radius: var(--border-radius-sm);
            border-left: 4px solid var(--primary-soft);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .hero-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-actions {
                flex-direction: column;
                width: 100%;
            }

            .status-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .info-cards-secondary {
                grid-template-columns: 1fr;
            }

            .schedule-divider {
                flex-direction: column;
                gap: 0.5rem;
            }

            .divider-line {
                height: 1px;
                width: 50px;
            }

            .cost-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        /* Animation for loading states */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-card {
            animation: fadeIn 0.6s ease-out;
        }

        .info-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .info-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .info-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Image zoom functionality
            const trainingImage = document.querySelector('.training-image img');
            if (trainingImage) {
                trainingImage.addEventListener('click', function() {
                    // Simple modal or lightbox functionality can be added here
                    window.open(this.src, '_blank');
                });
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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
        });
    </script>
@endsection
