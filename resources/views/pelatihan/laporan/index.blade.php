@extends('layouts.pelatihan.app')

@section('title', 'Laporan Pelatihan User')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-graph-up-arrow me-3"></i>
                        Laporan Pelatihan
                    </h1>
                    <p class="hero-subtitle">Pantau dan kelola laporan hasil pelatihan yang telah Anda ikuti</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.pendaftaran') }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-clipboard-check me-2"></i>
                        <span>Pendaftaran</span>
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
                <h6 class="info-title">Informasi Laporan</h6>
                <p class="info-text">
                    Halaman ini menampilkan laporan pelatihan yang telah Anda selesaikan. Anda dapat mengunduh
                    <span class="status-highlight status-processed">Laporan</span> dan
                    <span class="status-highlight status-accepted">Sertifikat</span>
                    pelatihan yang telah diselesaikan.
                </p>
            </div>
        </div>

        <!-- Main Data Card -->
        <div class="main-card">
            <!-- Advanced Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="bi bi-funnel-fill me-2"></i>
                        Filter & Pencarian
                    </h5>
                    <div class="filter-actions">
                        <div class="dropdown">
                            <button class="btn btn-elegant btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                id="columnDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <i class="bi bi-columns-gap me-1"></i>
                                Tampilkan Kolom
                            </button>
                            <ul class="dropdown-menu dropdown-menu-modern" aria-labelledby="columnDropdown">
                                @foreach (['no', 'judul', 'latar', 'hasil', 'biaya', 'laporan', 'sertifikat', 'aksi'] as $col)
                                    <li>
                                        <label class="dropdown-item-modern">
                                            <input type="checkbox" class="form-check-input me-2 toggle-col"
                                                data-target="{{ $col }}" checked>
                                            <span class="column-label">
                                                <i
                                                    class="bi bi-{{ $col === 'no' ? 'hash' : ($col === 'judul' ? 'bookmark' : ($col === 'latar' ? 'info-circle' : ($col === 'hasil' ? 'check-circle' : ($col === 'biaya' ? 'currency-dollar' : ($col === 'laporan' ? 'file-text' : ($col === 'sertifikat' ? 'award' : 'gear')))))) }} me-2"></i>
                                                {{ ucfirst($col) }}
                                            </span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <form method="GET" id="filterForm" class="filter-form">
                    <div class="filter-grid">
                        <!-- Search Input -->
                        <div class="filter-group search-group">
                            <label class="filter-label">
                                <i class="bi bi-search me-1"></i>
                                Pencarian
                            </label>
                            <div class="search-wrapper">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" name="search" id="searchInput"
                                    class="form-control modern-input search-input" placeholder="Cari laporan pelatihan..."
                                    value="{{ request('search') }}">
                                @if (request('search'))
                                    <button type="button" class="clear-search" onclick="clearSearch()">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Enhanced Table Section -->
            <div class="table-section">
                <div class="table-wrapper">
                    <div class="modern-table-container" id="laporan-table">
                        @include('pelatihan.laporan._table', ['laporans' => $laporans])
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div id="loading-spinner" class="loading-overlay d-none">
                    <div class="loading-content">
                        <div class="spinner-modern">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <p class="loading-text">Memuat data laporan...</p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Pagination Section -->
            <div class="pagination-section">
                <div class="pagination-info">
                    <span class="result-count">
                        <i class="bi bi-list-ul me-2"></i>
                        Menampilkan <strong>{{ $laporans->firstItem() ?? 0 }}</strong> -
                        <strong>{{ $laporans->lastItem() ?? 0 }}</strong> dari
                        <strong>{{ $laporans->total() }}</strong> laporan
                    </span>
                </div>

                @if ($laporans->hasPages())
                    <div class="pagination-controls">
                        <nav aria-label="Navigasi halaman">
                            <ul class="modern-pagination">
                                {{-- Previous Page Link --}}
                                @if ($laporans->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $laporans->previousPageUrl() }}"
                                            aria-label="Halaman sebelumnya">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max($laporans->currentPage() - 2, 1);
                                    $end = min($start + 4, $laporans->lastPage());
                                    $start = max($end - 4, 1);
                                @endphp

                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $laporans->url(1) }}">1</a>
                                    </li>
                                    @if ($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $laporans->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $laporans->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if ($end < $laporans->lastPage())
                                    @if ($end < $laporans->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $laporans->url($laporans->lastPage()) }}">{{ $laporans->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($laporans->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $laporans->nextPageUrl() }}"
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

        .status-highlight.status-processed {
            background: var(--info-soft);
            color: #1565c0;
        }

        .status-highlight.status-accepted {
            background: var(--success-soft);
            color: #2e7d32;
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
            grid-template-columns: 1fr;
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

        .clear-search {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            z-index: 2;
        }

        .clear-search:hover {
            color: var(--danger-color);
        }

        .modern-input {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--bg-primary);
        }

        .modern-input:focus {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
            outline: none;
        }

        /* Dropdown Menu */
        .dropdown-menu-modern {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow-md);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item-modern {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: var(--border-radius-sm);
            margin-bottom: 0.25rem;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            background: none;
            width: 100%;
        }

        .dropdown-item-modern:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .column-label {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        /* Table Section */
        .table-section {
            padding: 0;
            position: relative;
        }

        .table-wrapper {
            overflow: hidden;
        }

        .modern-table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .loading-content {
            text-align: center;
            color: var(--text-secondary);
        }

        .spinner-modern {
            margin-bottom: 1rem;
        }

        .loading-text {
            font-weight: 500;
            margin: 0;
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

        /* Form Controls */
        .form-check-input {
            border: 2px solid var(--border-color);
            border-radius: 0.25rem;
            width: 1.125rem;
            height: 1.125rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-soft);
            border-color: var(--primary-soft);
        }

        .form-check-input:focus {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
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

            .pagination-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .modern-pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .filter-actions {
                width: 100%;
            }

            .dropdown {
                width: 100%;
            }

            .dropdown button {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Global CSS variables are used - no local overrides needed */
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            let delayTimer;

            // Search functionality with debounce
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(delayTimer);
                    let query = this.value;
                    delayTimer = setTimeout(function() {
                        fetchData(1, query);
                    }, 500);
                });
            }

            // Pagination functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const link = e.target.closest('.pagination a');
                    const href = link.getAttribute('href');
                    if (href && href !== '#') {
                        const page = href.split('page=')[1];
                        const query = searchInput ? searchInput.value : '';
                        fetchData(page, query);
                    }
                }
            });

            // Clear search functionality
            window.clearSearch = function() {
                if (searchInput) {
                    searchInput.value = '';
                    fetchData(1, '');
                }
            };

            // Fetch data function
            function fetchData(page, query = '') {
                const tableContainer = document.getElementById('laporan-table');
                const loadingSpinner = document.getElementById('loading-spinner');
                const paginationSection = document.querySelector('.pagination-section');

                // Show loading state
                if (loadingSpinner) {
                    loadingSpinner.classList.remove('d-none');
                }

                // Disable pagination links
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.style.pointerEvents = 'none';
                    link.style.opacity = '0.6';
                });

                // Prepare URL
                const url = new URL(window.location);
                url.searchParams.set('page', page);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }

                fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');

                        // Update table content
                        const newTable = doc.querySelector('#laporan-table');
                        if (newTable && tableContainer) {
                            tableContainer.innerHTML = newTable.innerHTML;
                        }

                        // Update pagination
                        const newPagination = doc.querySelector('.pagination-section');
                        if (newPagination && paginationSection) {
                            paginationSection.innerHTML = newPagination.innerHTML;
                        }

                        // Update URL without reload
                        window.history.pushState({}, '', url);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        // Show error message
                        if (tableContainer) {
                            tableContainer.innerHTML = `
                            <div class="text-center py-5">
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Gagal memuat data</h5>
                                <p class="text-muted">Silakan refresh halaman atau coba lagi nanti</p>
                                <button class="btn btn-elegant btn-outline-secondary" onclick="location.reload()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                                </button>
                            </div>
                        `;
                        }
                    })
                    .finally(() => {
                        // Hide loading state
                        if (loadingSpinner) {
                            loadingSpinner.classList.add('d-none');
                        }

                        // Re-enable pagination links
                        document.querySelectorAll('.pagination a').forEach(link => {
                            link.style.pointerEvents = 'auto';
                            link.style.opacity = '1';
                        });

                        // Reapply column toggle states
                        document.querySelectorAll('.toggle-col').forEach(checkbox => {
                            const target = checkbox.dataset.target;
                            const selector = '.col-' + target;
                            const elements = document.querySelectorAll(selector);
                            elements.forEach(el => {
                                el.style.display = checkbox.checked ? '' : 'none';
                            });
                        });
                    });
            }

            // Column toggle functionality
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('toggle-col')) {
                    const target = e.target.dataset.target;
                    const selector = '.col-' + target;
                    const elements = document.querySelectorAll(selector);
                    elements.forEach(el => {
                        el.style.display = e.target.checked ? '' : 'none';
                    });
                }
            });

            // Add loading states to pagination
            document.addEventListener('click', function(e) {
                const pageLink = e.target.closest('.page-link');
                if (pageLink && !pageLink.parentElement.classList.contains('disabled')) {
                    const originalText = pageLink.innerHTML;
                    pageLink.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';

                    setTimeout(() => {
                        if (pageLink.innerHTML.includes('spin')) {
                            pageLink.innerHTML = originalText;
                        }
                    }, 3000);
                }
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
    </style>
@endsection
