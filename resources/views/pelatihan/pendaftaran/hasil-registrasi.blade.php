@extends('layouts.pelatihan.app')

@section('title', 'Hasil Pendaftaran Pelatihan')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-clipboard-check-fill me-3"></i>
                        Hasil Pendaftaran Pelatihan
                    </h1>
                    <p class="hero-subtitle">Pantau status dan riwayat pendaftaran pelatihan Anda dengan mudah</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-mortarboard me-2"></i>
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
                <h6 class="info-title">Informasi Status Pendaftaran</h6>
                <p class="info-text">
                    <span class="status-highlight status-saved">"Calon Peserta"</span> - Menunggu konfirmasi.
                    <span class="status-highlight status-processed">"Peserta"</span> - Terkonfirmasi sebagai peserta aktif.
                    <span class="status-highlight status-accepted">"Alumni"</span> - Telah menyelesaikan pelatihan.
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
                        <button type="button" class="btn btn-elegant btn-outline-secondary btn-sm"
                            onclick="resetFilters()">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset
                        </button>
                    </div>
                </div>

                <form method="GET" action="{{ route('pelatihan.pendaftaran') }}" id="filterForm" class="filter-form">
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
                                    placeholder="Cari nama pelatihan, penyelenggara..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Status Verifikasi Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-check-circle me-1"></i>
                                Status Verifikasi
                            </label>
                            <select name="verifikasi" class="form-select modern-select">
                                <option value="">Semua Status</option>
                                <option value="tersimpan" {{ request('verifikasi') == 'tersimpan' ? 'selected' : '' }}>
                                    Tersimpan</option>
                                <option value="terkirim" {{ request('verifikasi') == 'terkirim' ? 'selected' : '' }}>
                                    Terkirim</option>
                                <option value="diterima" {{ request('verifikasi') == 'diterima' ? 'selected' : '' }}>
                                    Diterima</option>
                                <option value="ditolak" {{ request('verifikasi') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>

                        <!-- Status Peserta Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-people me-1"></i>
                                Status Peserta
                            </label>
                            <select name="peserta" class="form-select modern-select">
                                <option value="">Semua Peserta</option>
                                <option value="calon_peserta" {{ request('peserta') == 'calon_peserta' ? 'selected' : '' }}>
                                    Calon Peserta</option>
                                <option value="peserta" {{ request('peserta') == 'peserta' ? 'selected' : '' }}>Peserta
                                </option>
                                <option value="alumni" {{ request('peserta') == 'alumni' ? 'selected' : '' }}>Alumni
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modern Table Section -->
            <div class="table-section">
                <div class="table-wrapper">
                    <div class="modern-table-container">
                        @include('pelatihan.pendaftaran._table', ['pendaftarans' => $pendaftarans])
                    </div>
                </div>
            </div>

            <!-- Enhanced Pagination Section -->
            <div class="pagination-section">
                <div class="pagination-info">
                    <span class="result-count">
                        <i class="bi bi-list-ul me-2"></i>
                        Menampilkan <strong>{{ $pendaftarans->firstItem() ?? 0 }}</strong> -
                        <strong>{{ $pendaftarans->lastItem() ?? 0 }}</strong> dari
                        <strong>{{ $pendaftarans->total() }}</strong> pendaftaran
                    </span>
                </div>

                @if ($pendaftarans->hasPages())
                    <div class="pagination-controls">
                        <nav aria-label="Navigasi halaman">
                            <ul class="modern-pagination">
                                {{-- Previous Page Link --}}
                                @if ($pendaftarans->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pendaftarans->previousPageUrl() }}"
                                            aria-label="Halaman sebelumnya">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max($pendaftarans->currentPage() - 2, 1);
                                    $end = min($start + 4, $pendaftarans->lastPage());
                                    $start = max($end - 4, 1);
                                @endphp

                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pendaftarans->url(1) }}">1</a>
                                    </li>
                                    @if ($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $pendaftarans->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $pendaftarans->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if ($end < $pendaftarans->lastPage())
                                    @if ($end < $pendaftarans->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $pendaftarans->url($pendaftarans->lastPage()) }}">{{ $pendaftarans->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($pendaftarans->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pendaftarans->nextPageUrl() }}"
                                            aria-label="Halaman selanjutnya">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto submit form when filter changes
            const filterForm = document.getElementById('filterForm');
            const filterSelects = filterForm.querySelectorAll('select');
            const searchInput = filterForm.querySelector('input[name="search"]');

            // For select elements
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    filterForm.submit();
                });
            });

            // For search input with debounce
            let searchTimer;
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                });
            }

            // Reset filters function
            window.resetFilters = function() {
                // Reset all form inputs
                filterForm.reset();

                // Update URL without parameters
                const url = new URL(window.location);
                url.search = '';
                window.history.pushState({}, '', url);

                // Reload page
                window.location.reload();
            };

            // Add loading states to filter changes
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.disabled = true;
                    this.style.opacity = '0.6';

                    // Create loading indicator
                    const loader = document.createElement('div');
                    loader.className = 'filter-loader';
                    loader.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
                    this.parentNode.appendChild(loader);
                });
            });

            // Smooth scrolling for pagination
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.href || this.href.includes('#')) return;

                    e.preventDefault();

                    // Add loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
                    this.style.pointerEvents = 'none';

                    // Navigate after short delay for visual feedback
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 200);
                });
            });
        });
    </script>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .filter-loader {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-soft);
        }
    </style>
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
            margin: 0 0.25rem;
        }

        .status-highlight.status-saved {
            background: var(--success-soft);
            color: #2e7d32;
        }

        .status-highlight.status-processed {
            background: var(--info-soft);
            color: #1565c0;
        }

        .status-highlight.status-accepted {
            background: var(--warning-soft);
            color: #f57c00;
        }

        /* Main Card */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* Filter Section */
        .filter-section {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 2rem;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filter-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .filter-actions {
            display: flex;
            gap: 0.75rem;
        }

        .filter-form {
            margin: 0;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 1.5rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
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
            z-index: 2;
        }

        .search-input {
            padding-left: 2.5rem;
        }

        .modern-input,
        .modern-select {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--bg-primary);
        }

        .modern-input:focus,
        .modern-select:focus {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
            outline: none;
        }

        /* Table Section */
        .table-section {
            padding: 0;
        }

        .table-wrapper {
            overflow: hidden;
        }

        .modern-table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Enhanced table styles */
        .modern-table-container table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .modern-table-container th {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, #f1f5f9 100%);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modern-table-container td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modern-table-container tbody tr {
            transition: var(--transition);
        }

        .modern-table-container tbody tr:nth-child(even) {
            background: rgba(248, 250, 252, 0.5);
        }

        .modern-table-container tbody tr:hover {
            background: rgba(139, 157, 195, 0.05);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Pagination Section */
        .pagination-section {
            background: var(--bg-primary);
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .result-count {
            display: flex;
            align-items: center;
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

        .btn-elegant.btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .filter-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
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

            .pagination-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .modern-pagination {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        /* Loading states */
        .filter-loader {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-soft);
        }

        /* Status badges in table */
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

        .status-badge.pending {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
        }

        .status-badge.approved {
            background: rgba(34, 197, 94, 0.15);
            color: #16a34a;
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .status-badge.completed {
            background: rgba(168, 85, 247, 0.15);
            color: #9333ea;
        }

        /* Currency formatting */
        .currency {
            font-family: 'Familjen Grotesk', sans-serif;
            font-weight: 600;
            color: var(--text-primary);
        }
    </style>
@endsection
