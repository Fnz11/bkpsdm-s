@extends('layouts.pelatihan.app')

@section('title', 'Detail Laporan - ' . $laporan->judul_laporan)

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-file-text-fill me-3"></i>
                        Detail Laporan Pelatihan
                    </h1>
                    <p class="hero-subtitle">{{ $laporan->judul_laporan }}</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.laporan') }}" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb-card">
            <nav aria-label="breadcrumb">
                <ol class="modern-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pelatihan.laporan') }}" class="breadcrumb-link">
                            <i class="bi bi-graph-up-arrow me-1"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Laporan</li>
                </ol>
            </nav>
        </div>

        <!-- Main Content Layout -->
        <div class="row g-4">
            <!-- Left Column - Main Information -->
            <div class="col-lg-8">
                <!-- Main Information Card -->
                <div class="main-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title">{{ $laporan->judul_laporan }}</h3>
                                <p class="card-subtitle">Informasi lengkap laporan pelatihan</p>
                            </div>
                            <div class="status-badges">
                                @if($laporan->hasil_pelatihan == 'lulus')
                                    <span class="status-badge status-success">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Lulus
                                    </span>
                                @else
                                    <span class="status-badge status-danger">
                                        <i class="bi bi-x-circle-fill me-2"></i>
                                        Tidak Lulus
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Training Information Grid -->
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon bg-primary">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Nama Pelatihan</span>
                                    <span class="info-value">
                                        {{ $laporan->pendaftaran->tersedia->nama_pelatihan ?? $laporan->pendaftaran->usulan->nama_pelatihan ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon bg-info">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Peserta</span>
                                    <span class="info-value">{{ $laporan->pendaftaran->user->name ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon bg-secondary">
                                    <i class="bi bi-card-text"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">NIP</span>
                                    <span class="info-value">{{ $laporan->pendaftaran->user_nip ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon bg-warning">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Tanggal Laporan</span>
                                    <span class="info-value">
                                        {{ \Carbon\Carbon::parse($laporan->created_at)->isoFormat('D MMMM Y, HH:mm') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background Section -->
                <div class="main-card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="bi bi-file-text me-2"></i>
                            Latar Belakang
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="content-box">
                            <p class="content-text">{{ $laporan->latar_belakang }}</p>
                        </div>
                    </div>
                </div>

                <!-- Training Details (if available) -->
                @if($laporan->pendaftaran->tersedia)
                <div class="main-card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>
                            Detail Pelatihan
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Penyelenggara</span>
                                    <span class="detail-value">{{ $laporan->pendaftaran->tersedia->penyelenggara_pelatihan ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Lokasi</span>
                                    <span class="detail-value">{{ $laporan->pendaftaran->tersedia->tempat_pelatihan ?? '-' }}</span>
                                </div>
                            </div>

                            @if($laporan->pendaftaran->tersedia->tanggal_mulai && $laporan->pendaftaran->tersedia->tanggal_selesai)
                            <div class="detail-item full-width">
                                <div class="detail-icon">
                                    <i class="bi bi-calendar-range"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Periode Pelaksanaan</span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($laporan->pendaftaran->tersedia->tanggal_mulai)->isoFormat('D MMMM Y') }} - 
                                        {{ \Carbon\Carbon::parse($laporan->pendaftaran->tersedia->tanggal_selesai)->isoFormat('D MMMM Y') }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Summary & Actions -->
            <div class="col-lg-4">
                <!-- Cost Summary Card -->
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="summary-info">
                            <h6 class="summary-title">Total Biaya</h6>
                            <p class="summary-subtitle">Biaya keseluruhan pelatihan</p>
                        </div>
                    </div>
                    <div class="summary-amount">
                        <span class="amount-value">Rp{{ number_format($laporan->total_biaya, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="main-card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="bi bi-files me-2"></i>
                            Dokumen
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ asset('storage/sertifikat/' . $laporan->sertifikat) }}" 
                               target="_blank" 
                               class="btn btn-elegant btn-outline-success">
                                <i class="bi bi-award me-2"></i>
                                Lihat Sertifikat
                            </a>

                            <a href="{{ asset('storage/laporan/' . $laporan->laporan) }}" 
                               target="_blank" 
                               class="btn btn-elegant btn-outline-info">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="stats-card">
                    <div class="stats-header">
                        <h6 class="stats-title">
                            <i class="bi bi-graph-up me-2"></i>
                            Statistik Singkat
                        </h6>
                    </div>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon {{ $laporan->hasil_pelatihan == 'lulus' ? 'success' : 'danger' }}">
                                <i class="bi bi-{{ $laporan->hasil_pelatihan == 'lulus' ? 'check-circle' : 'x-circle' }}"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Status</span>
                                <span class="stat-value">{{ $laporan->hasil_pelatihan == 'lulus' ? 'Lulus' : 'Tidak Lulus' }}</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon info">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Dibuat</span>
                                <span class="stat-value">{{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }}</span>
                            </div>
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

        /* Breadcrumb */
        .breadcrumb-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius-sm);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .modern-breadcrumb {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modern-breadcrumb .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .modern-breadcrumb .breadcrumb-item:not(:last-child)::after {
            content: '/';
            margin-left: 0.5rem;
            color: var(--text-muted);
        }

        .breadcrumb-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .breadcrumb-link:hover {
            color: var(--primary-dark);
        }

        .modern-breadcrumb .breadcrumb-item.active {
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Main Cards */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: var(--bg-secondary);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
        }

        .card-subtitle {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }

        .card-body {
            padding: 2rem;
        }

        /* Status Badges */
        .status-badges {
            display: flex;
            gap: 0.5rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .status-badge.status-success {
            background: linear-gradient(135deg, var(--success-soft), #81c784);
            color: #1b5e20;
        }

        .status-badge.status-danger {
            background: linear-gradient(135deg, var(--danger-soft), #e57373);
            color: #b71c1c;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .info-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .info-icon.bg-primary {
            background: var(--gradient-primary);
        }

        .info-icon.bg-info {
            background: linear-gradient(135deg, var(--info-soft), #4fc3f7);
        }

        .info-icon.bg-secondary {
            background: var(--gradient-secondary);
        }

        .info-icon.bg-warning {
            background: linear-gradient(135deg, var(--warning-soft), #ffb74d);
        }

        .info-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Content Box */
        .content-box {
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            padding: 1.5rem;
        }

        .content-text {
            color: var(--text-primary);
            line-height: 1.7;
            margin: 0;
            text-align: justify;
        }

        /* Detail Grid */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .detail-item:hover {
            border-color: var(--primary-soft);
            background: var(--bg-secondary);
        }

        .detail-item.full-width {
            grid-column: 1 / -1;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-soft);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .detail-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Summary Card */
        .summary-card {
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: var(--shadow-md);
        }

        .summary-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .summary-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .summary-info h6 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .summary-info p {
            font-size: 0.875rem;
            opacity: 0.9;
            margin: 0;
        }

        .summary-amount {
            text-align: center;
        }

        .amount-value {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Stats Card */
        .stats-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .stats-header {
            background: var(--bg-secondary);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .stats-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .stats-grid {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .stat-icon.success {
            background: var(--gradient-success);
        }

        .stat-icon.danger {
            background: var(--gradient-danger);
        }

        .stat-icon.info {
            background: linear-gradient(135deg, var(--info-soft), #4fc3f7);
        }

        .stat-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Buttons */
        .btn-elegant {
            font-weight: 600;
            padding: 0.625rem 1.25rem;
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
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-outline-success {
            color: var(--success-color);
            border-color: var(--success-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-success:hover {
            background: var(--success-color);
            border-color: var(--success-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-outline-info {
            color: var(--accent-color);
            border-color: var(--accent-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-info:hover {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .detail-grid {
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

            .hero-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .card-header {
                padding: 1.25rem 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .summary-card {
                padding: 1.5rem;
            }

            .summary-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .amount-value {
                font-size: 1.75rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .hero-header {
                padding: 2rem 1.5rem;
            }

            .breadcrumb-card {
                padding: 0.75rem 1rem;
            }

            .modern-breadcrumb {
                flex-wrap: wrap;
            }

            .stats-grid {
                padding: 1rem;
            }

            .stat-item {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }
        }
    </style>
@endsection