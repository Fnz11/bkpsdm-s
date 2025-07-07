@extends('layouts.pelatihan.app')

@section('title', 'Daftar Pelatihan Tersedia')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-mortarboard-fill me-3"></i>
                        Daftar Pelatihan Tersedia
                    </h1>
                    <p class="hero-subtitle">Temukan dan ikuti pelatihan berkualitas untuk mengembangkan kompetensi Anda</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Usulan Pelatihan</span>
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
                <h6 class="info-title">Informasi Pelatihan</h6>
                <p class="info-text">
                    <span class="status-highlight status-open">"Buka"</span> - Pendaftaran masih tersedia.
                    <span class="status-highlight status-closed">"Tutup"</span> - Pendaftaran telah berakhir.
                    <span class="status-highlight status-full">"Penuh"</span> - Kuota peserta telah terpenuhi.
                </p>
            </div>
        </div>

        <!-- Main Data Card -->
        <div class="main-card">
            <!-- Advanced Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h3 class="filter-title">
                        <i class="bi bi-funnel me-2"></i>
                        Filter & Pencarian
                    </h3>
                    <div class="filter-actions">
                        @if (request()->hasAny(['search', 'jenis', 'metode', 'status', 'start', 'end']))
                            <a href="{{ route('pelatihan.tersedia') }}"
                                class="btn btn-elegant btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('pelatihan.tersedia') }}" id="filterForm" class="filter-form">
                    <div class="filter-grid">
                        <!-- Search Input -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-search me-1"></i>
                                Pencarian
                            </label>
                            <div class="search-wrapper">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" name="search" class="form-control modern-input search-input"
                                    placeholder="Cari nama pelatihan, kategori, atau tempat..."
                                    value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Jenis Pelatihan Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-bookmark me-1"></i>
                                Jenis Pelatihan
                            </label>
                            <select name="jenis" class="form-select modern-select">
                                <option value="">Semua Jenis</option>
                                @foreach ($jenisPelatihan as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Metode Pelatihan Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-laptop me-1"></i>
                                Metode Pelatihan
                            </label>
                            <select name="metode" class="form-select modern-select">
                                <option value="">Semua Metode</option>
                                @foreach ($metodePelatihan as $metode)
                                    <option value="{{ $metode->id }}"
                                        {{ request('metode') == $metode->id ? 'selected' : '' }}>
                                        {{ $metode->metode_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-toggle-on me-1"></i>
                                Status Pendaftaran
                            </label>
                            <select name="status" class="form-select modern-select">
                                <option value="">Semua Status</option>
                                <option value="buka" {{ request('status') == 'buka' ? 'selected' : '' }}>Buka</option>
                                <option value="tutup" {{ request('status') == 'tutup' ? 'selected' : '' }}>Tutup</option>
                            </select>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-calendar-range me-1"></i>
                                Periode Pelaksanaan
                            </label>
                            <div class="date-range-wrapper">
                                <input type="date" name="start" class="form-control modern-input date-input"
                                    value="{{ request('start') }}" placeholder="Tanggal Mulai">
                                <span class="date-separator">s/d</span>
                                <input type="date" name="end" class="form-control modern-input date-input"
                                    value="{{ request('end') }}" placeholder="Tanggal Selesai">
                            </div>
                        </div>
                    </div>

                    <!-- Filter Submit Button -->
                    <div class="filter-submit">
                        <button type="submit" class="btn btn-elegant btn-primary">
                            <i class="bi bi-search me-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Training Cards Section -->
            <div class="table-section">
                @if ($pelatihan->count() > 0)
                    <div class="training-grid">
                        @foreach ($pelatihan as $item)
                            <article class="training-card">
                                <div class="card-image">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            alt="{{ $item->nama_pelatihan }}" class="training-img"
                                            onerror="this.src='{{ asset('images/training-placeholder.jpg') }}'">
                                    @else
                                        <div class="image-placeholder">
                                            <i class="bi bi-mortarboard-fill"></i>
                                            <span>Gambar Pelatihan</span>
                                        </div>
                                    @endif
                                    <div class="card-badges">
                                        <span
                                            class="badge badge-type">{{ $item->jenispelatihan->jenis_pelatihan ?? '-' }}</span>
                                        <span
                                            class="badge badge-method">{{ $item->metodepelatihan->metode_pelatihan ?? '-' }}</span>
                                    </div>
                                    <div class="card-status">
                                        <span
                                            class="status-badge {{ $item->status_pelatihan == 'buka' ? 'status-open' : 'status-closed' }}">
                                            <i
                                                class="bi {{ $item->status_pelatihan == 'buka' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                            {{ $item->status_pelatihan == 'buka' ? 'Buka' : 'Tutup' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <h3 class="card-title">{{ $item->nama_pelatihan }}</h3>
                                    <p class="card-description">{{ Str::limit($item->deskripsi, 120, '...') }}</p>

                                    <div class="card-details">
                                        <div class="detail-item">
                                            <i class="bi bi-calendar-event"></i>
                                            <div class="detail-text">
                                                <span class="detail-label">Periode</span>
                                                <span class="detail-value">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <div class="detail-text">
                                                <span class="detail-label">Lokasi</span>
                                                <span class="detail-value">{{ $item->tempat_pelatihan }}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-people"></i>
                                            <div class="detail-text">
                                                <span class="detail-label">Kuota</span>
                                                <span class="detail-value">{{ $item->kuota }} Peserta</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-actions">
                                    <a href="{{ route('pelatihan.tersedia.show', $item->id) }}"
                                        class="btn btn-elegant btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>
                                        Lihat Detail
                                    </a>
                                    {{-- @if ($item->status_pelatihan == 'buka')
                                        <a href="#" class="btn btn-elegant btn-primary btn-sm">
                                            <i class="bi bi-person-plus me-1"></i>
                                            Daftar
                                        </a>
                                    @endif --}}
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="empty-title">Tidak Ada Pelatihan Ditemukan</h3>
                        <p class="empty-text">
                            Tidak ada pelatihan yang sesuai dengan filter yang Anda pilih.
                            Coba ubah kriteria pencarian atau reset filter.
                        </p>
                        <a href="{{ route('pelatihan.tersedia') }}" class="btn btn-elegant btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pagination Section -->
            @if ($pelatihan->hasPages())
                <div class="pagination-section">
                    <div class="pagination-info">
                        <span class="result-count">
                            Menampilkan {{ $pelatihan->firstItem() ?? 0 }} - {{ $pelatihan->lastItem() ?? 0 }}
                            dari {{ $pelatihan->total() }} pelatihan
                        </span>
                    </div>
                    <nav aria-label="Pagination">
                        <ul class="modern-pagination">
                            {{-- Previous Page Link --}}
                            @if ($pelatihan->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pelatihan->previousPageUrl() }}"><i
                                            class="bi bi-chevron-left"></i></a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($pelatihan->getUrlRange(1, $pelatihan->lastPage()) as $page => $url)
                                @if ($page == $pelatihan->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($pelatihan->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pelatihan->nextPageUrl() }}"><i
                                            class="bi bi-chevron-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        /* Modern Global Color Palette */
        :root {
            --primary-soft: #8b9dc3;
            --primary-hover: #6b9aa1;
            --secondary-soft: #a8a8a8;
            --success-soft: #a5d6a7;
            --info-soft: #b3e5fc;
            --warning-soft: #ffe082;
            --danger-soft: #ef9a9a;
            --light-soft: #fafafa;
            --dark-soft: #5d5d5d;
            --gradient-primary: linear-gradient(135deg, var(--primary-soft), var(--primary-hover));
            --gradient-secondary: linear-gradient(135deg, var(--secondary-soft), #8e8e8e);
            --gradient-success: linear-gradient(135deg, var(--success-soft), #81c784);
            --gradient-danger: linear-gradient(135deg, var(--danger-soft), #e57373);

            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #2c3e50;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e5e7eb;
            --border-radius: 1rem;
            --border-radius-sm: 0.5rem;
            --border-radius-lg: 1.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern Container */
        .modern-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            background: var(--bg-secondary);
        }

        /* Hero Header Section */
        .hero-header {
            background: var(--gradient-primary);
            border-radius: var(--border-radius-lg);
            padding: 3rem 4rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border-radius: 50%;
            transform: translate(50px, -50px);
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
            margin: 0;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.125rem;
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-weight: 400;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        /* Info Card */
        .info-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: var(--shadow-md);
            border-left: 4px solid var(--primary-soft);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: rgba(139, 157, 195, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-soft);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .info-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
        }

        .info-text {
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.6;
        }

        .status-highlight {
            background: rgba(139, 157, 195, 0.1);
            color: var(--primary-soft);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-highlight.status-open {
            background: rgba(165, 214, 167, 0.2);
            color: #2e7d32;
        }

        .status-highlight.status-closed {
            background: rgba(239, 154, 154, 0.2);
            color: #c62828;
        }

        .status-highlight.status-full {
            background: rgba(255, 224, 130, 0.2);
            color: #f57c00;
        }

        /* Main Card */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        /* Filter Section */
        .filter-section {
            background: var(--bg-primary);
            padding: 2rem;
            border-bottom: 2px solid var(--bg-secondary);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .filter-actions {
            display: flex;
            gap: 1rem;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
        }

        .search-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 1;
        }

        .modern-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 0.875rem;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .modern-input:focus {
            outline: none;
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 4px rgba(139, 157, 195, 0.1);
        }

        .modern-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .modern-select:focus {
            outline: none;
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 4px rgba(139, 157, 195, 0.1);
        }

        .date-range-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .date-input {
            flex: 1;
        }

        .date-separator {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .filter-submit {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
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
            font-size: 0.875rem;
            cursor: pointer;
        }

        .btn-elegant.btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-soft);
        }

        .btn-elegant.btn-primary:hover {
            background: linear-gradient(135deg, #6b9aa1, #5a8a91);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-outline-light {
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-elegant.btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
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
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
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

        .btn-elegant.btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }

        /* Training Grid */
        .table-section {
            background: var(--bg-primary);
            padding: 2rem;
        }

        .training-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .training-card {
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .training-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-soft);
        }

        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .training-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .training-card:hover .training-img {
            transform: scale(1.05);
        }

        .image-placeholder {
            width: 100%;
            height: 100%;
            background: var(--bg-secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            gap: 0.5rem;
        }

        .image-placeholder i {
            font-size: 3rem;
        }

        .card-badges {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            backdrop-filter: blur(10px);
        }

        .badge-type {
            background: rgba(139, 157, 195, 0.9);
            color: white;
        }

        .badge-method {
            background: rgba(168, 168, 168, 0.9);
            color: white;
        }

        .card-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
        }

        .status-badge.status-open {
            background: rgba(165, 214, 167, 0.9);
            color: #1b5e20;
        }

        .status-badge.status-closed {
            background: rgba(239, 154, 154, 0.9);
            color: #b71c1c;
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 1rem 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .detail-item i {
            color: var(--primary-soft);
            font-size: 1.125rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .detail-text {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .detail-value {
            color: var(--text-primary);
            font-weight: 500;
            line-height: 1.4;
        }

        .card-actions {
            display: flex;
            gap: 0.75rem;
            padding: 1.5rem;
            border-top: 2px solid var(--bg-secondary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: var(--text-muted);
            font-size: 2rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-text {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Pagination Section */
        .pagination-section {
            background: var(--bg-primary);
            padding: 1.5rem 2rem;
            border-top: 2px solid var(--bg-secondary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .modern-pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.25rem;
        }

        .modern-pagination .page-item {
            margin: 0;
        }

        .modern-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0.5rem;
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .modern-pagination .page-link:hover {
            background: var(--primary-soft);
            border-color: var(--primary-soft);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .modern-pagination .page-item.active .page-link {
            background: var(--gradient-primary);
            border-color: var(--primary-soft);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .modern-pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--bg-secondary);
        }

        .modern-pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-muted);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .filter-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .training-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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

            .filter-section {
                padding: 1.5rem;
            }

            .filter-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .info-card {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .training-grid {
                grid-template-columns: 1fr;
            }

            .pagination-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .modern-pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .date-range-wrapper {
                flex-direction: column;
            }

            .card-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .card-content {
                padding: 1rem;
            }

            .card-actions {
                padding: 1rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form on filter change
            const filterForm = document.getElementById('filterForm');
            const filterSelects = filterForm.querySelectorAll('select, input[type="date"]');
            const searchInput = filterForm.querySelector('input[name="search"]');

            // Debounced search functionality
            let searchTimeout;
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                });
            }

            // Auto-submit on filter select change
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    filterForm.submit();
                });
            });

            // Initialize tooltips for action buttons
            const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipElements.forEach(element => {
                new bootstrap.Tooltip(element);
            });

            // Smooth scroll for pagination
            const paginationLinks = document.querySelectorAll('.modern-pagination .page-link');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Smooth scroll to top after pagination
                    setTimeout(() => {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 100);
                });
            });

            // Training card hover effects
            const trainingCards = document.querySelectorAll('.training-card');
            trainingCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Image error handling with fallback
            const trainingImages = document.querySelectorAll('.training-img');
            trainingImages.forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = this.parentElement.querySelector('.image-placeholder') ||
                        this.parentElement.appendChild(createImagePlaceholder());
                    placeholder.style.display = 'flex';
                });
            });

            function createImagePlaceholder() {
                const placeholder = document.createElement('div');
                placeholder.className = 'image-placeholder';
                placeholder.innerHTML = `
                    <i class="bi bi-mortarboard-fill"></i>
                    <span>Gambar Pelatihan</span>
                `;
                return placeholder;
            }

            // Status badge animations
            const statusBadges = document.querySelectorAll('.status-badge');
            statusBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Filter form validation
            const dateInputs = filterForm.querySelectorAll('input[type="date"]');
            const startDateInput = filterForm.querySelector('input[name="start"]');
            const endDateInput = filterForm.querySelector('input[name="end"]');

            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function() {
                    if (this.value && endDateInput.value && this.value > endDateInput.value) {
                        endDateInput.value = this.value;
                    }
                    endDateInput.min = this.value;
                });

                endDateInput.addEventListener('change', function() {
                    if (this.value && startDateInput.value && this.value < startDateInput.value) {
                        startDateInput.value = this.value;
                    }
                    startDateInput.max = this.value;
                });
            }

            // Enhanced search experience
            if (searchInput) {
                const searchWrapper = searchInput.closest('.search-wrapper');
                const searchIcon = searchWrapper.querySelector('.search-icon');

                searchInput.addEventListener('focus', function() {
                    searchWrapper.style.boxShadow = '0 0 0 4px rgba(139, 157, 195, 0.1)';
                    searchIcon.style.color = '#8b9dc3';
                });

                searchInput.addEventListener('blur', function() {
                    searchWrapper.style.boxShadow = 'none';
                    searchIcon.style.color = '#94a3b8';
                });
            }

            // Loading state for form submission
            filterForm.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="bi bi-arrow-repeat spin me-2"></i>Mencari...';
                    submitButton.disabled = true;

                    // Add spinner animation
                    const style = document.createElement('style');
                    style.textContent = `
                        .spin {
                            animation: spin 1s linear infinite;
                        }
                        @keyframes spin {
                            from { transform: rotate(0deg); }
                            to { transform: rotate(360deg); }
                        }
                    `;
                    document.head.appendChild(style);
                }
            });

            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const cardObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            trainingCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                cardObserver.observe(card);
            });

            // Enhanced button interactions
            const elegantButtons = document.querySelectorAll('.btn-elegant');
            elegantButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });

                button.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(0) scale(0.98)';
                });

                button.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-2px) scale(1)';
                });
            });
        });
    </script>
@endsection
