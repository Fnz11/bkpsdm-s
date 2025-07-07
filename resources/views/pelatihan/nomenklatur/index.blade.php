@extends('layouts.pelatihan.app')

@section('title', 'Usulan Nomenklatur Pelatihan')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-lightbulb-fill me-3"></i>
                        Usulan Nomenklatur Pelatihan
                    </h1>
                    <p class="hero-subtitle">Kelola dan pantau usulan nama pelatihan dari ASN dengan sistem yang modern dan efisien</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.create-nomenklatur') }}" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Usul Nama Pelatihan</span>
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
                <h6 class="info-title">Informasi Status Usulan</h6>
                <p class="info-text">
                    <span class="status-highlight status-saved">"Proses"</span> - Usulan sedang ditinjau.
                    <span class="status-highlight status-processed">"Diterima"</span> - Usulan telah disetujui.
                    <span class="status-highlight status-accepted">"Ditolak"</span> - Usulan memerlukan revisi.
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
                        <button type="button" class="btn btn-elegant btn-outline-secondary btn-sm" onclick="resetFilters()">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset
                        </button>
                    </div>
                </div>
                
                <form method="GET" action="{{ route('pelatihan.nomenklatur') }}" id="filterForm" class="filter-form">
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
                                    placeholder="Cari nama pelatihan, jenis..." 
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
                                @foreach($jenispelatihans as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-check-circle me-1"></i>
                                Status Usulan
                            </label>
                            <select name="status" class="form-select modern-select">
                                <option value="">Semua Status</option>
                                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Alert Section -->
            @if (session('success'))
                <div class="alert-section">
                    <div class="alert alert-success" id="successAlert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-wrapper">
                    <div class="modern-table-container">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">No</th>
                                    <th style="min-width: 250px;">Nama Pelatihan</th>
                                    <th style="width: 180px;">Jenis Pelatihan</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 200px;">Keterangan</th>
                                    <th style="width: 120px;">Tanggal Usulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($namapelatihans as $item)
                                    <tr>
                                        <td class="text-center">{{ $namapelatihans->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="training-name">
                                                <span class="name-text">{{ $item->nama_pelatihan }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="jenis-badge">{{ $item->jenispelatihan->jenis_pelatihan }}</span>
                                        </td>
                                        <td>
                                            @if ($item->status === 'diterima')
                                                <span class="status-badge approved">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Diterima
                                                </span>
                                            @elseif ($item->status === 'ditolak')
                                                <span class="status-badge rejected">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="status-badge pending">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Proses
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="keterangan-cell">
                                                {{ $item->keterangan ?: 'Belum ada keterangan' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="date-text">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="bi bi-inbox"></i>
                                                </div>
                                                <h6 class="empty-title">Belum Ada Usulan</h6>
                                                <p class="empty-text">Belum ada nama pelatihan yang diusulkan. Mulai dengan mengajukan usulan pertama Anda.</p>
                                                <a href="{{ route('pelatihan.create-nomenklatur') }}" class="btn btn-elegant btn-outline-primary btn-sm">
                                                    <i class="bi bi-plus-circle me-1"></i>
                                                    Buat Usulan Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination Section -->
            @if($namapelatihans->hasPages())
                <div class="pagination-section">
                    <div class="pagination-info">
                        <div class="result-count">
                            <i class="bi bi-list-ul me-2"></i>
                            Menampilkan <strong>{{ $namapelatihans->firstItem() ?: 0 }}</strong> - 
                            <strong>{{ $namapelatihans->lastItem() ?: 0 }}</strong> dari 
                            <strong>{{ $namapelatihans->total() }}</strong> usulan
                        </div>
                    </div>
                    <div class="pagination-controls">
                        <nav aria-label="Pagination Navigation">
                            <ul class="modern-pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $namapelatihans->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $namapelatihans->previousPageUrl() }}" aria-label="Previous">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max($namapelatihans->currentPage() - 2, 1);
                                    $end = min($start + 4, $namapelatihans->lastPage());
                                    $start = max($end - 4, 1);
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $namapelatihans->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $namapelatihans->currentPage() ? 'active' : '' }}">
                                        @if($i == $namapelatihans->currentPage())
                                            <span class="page-link">{{ $i }}</span>
                                        @else
                                            <a class="page-link" href="{{ $namapelatihans->url($i) }}">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor

                                @if($end < $namapelatihans->lastPage())
                                    @if($end < $namapelatihans->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $namapelatihans->url($namapelatihans->lastPage()) }}">{{ $namapelatihans->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                <li class="page-item {{ !$namapelatihans->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $namapelatihans->nextPageUrl() }}" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
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
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }

        .status-highlight.status-processed {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .status-highlight.status-accepted {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
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

        .modern-input, .modern-select {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--bg-primary);
        }

        .modern-input:focus, .modern-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
            outline: none;
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
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
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

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            margin: 0;
        }

        .modern-table th {
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

        .modern-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modern-table tbody tr {
            transition: var(--transition);
        }

        .modern-table tbody tr:nth-child(even) {
            background: rgba(248, 250, 252, 0.5);
        }

        .modern-table tbody tr:hover {
            background: rgba(139, 157, 195, 0.05);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Table Content Styles */
        .training-name {
            display: flex;
            flex-direction: column;
        }

        .name-text {
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.4;
        }

        .jenis-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            background: var(--primary-light);
            color: var(--primary-hover);
            border-radius: 1rem;
            font-weight: 500;
            font-size: 0.8125rem;
        }

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
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }

        .status-badge.approved {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .keterangan-cell {
            color: var(--text-secondary);
            line-height: 1.4;
            max-width: 200px;
        }

        .date-text {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.8125rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-icon {
            margin-bottom: 1.5rem;
        }

        .empty-icon i {
            font-size: 4rem;
            color: var(--text-muted);
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
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
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .modern-pagination .page-item.active .page-link {
            background: var(--gradient-primary);
            border-color: var(--primary-color);
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
            padding: 0.75rem 1.5rem;
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

        .btn-elegant.btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-sm {
            padding: 0.5rem 1rem;
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

            .modern-table th,
            .modern-table td {
                padding: 0.75rem 0.5rem;
            }

            .empty-state {
                padding: 2rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .info-card {
                flex-direction: column;
                text-align: center;
            }

            .modern-table {
                font-size: 0.8125rem;
            }

            .training-name {
                max-width: 150px;
            }

            .name-text {
                font-size: 0.8125rem;
            }

            .btn-elegant {
                padding: 0.625rem 1rem;
                font-size: 0.8125rem;
            }
        }

        /* Loading states */
        .filter-loader {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }

        /* Focus states for accessibility */
        .btn-elegant:focus,
        .modern-input:focus,
        .modern-select:focus,
        .page-link:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto submit form when filter changes
        const filterForm = document.getElementById('filterForm');
        const filterSelects = filterForm.querySelectorAll('select');
        const searchInput = filterForm.querySelector('input[type="text"]');
        
        // For select elements
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });
        
        // For search input with debounce
        let searchTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });
    });
</script>
@endsection