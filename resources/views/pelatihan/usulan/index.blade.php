@extends('layouts.pelatihan.app')

@section('title', 'Usulan Pelatihan Mandiri')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-mortarboard-fill me-3"></i>
                        Usulan Pelatihan Mandiri
                    </h1>
                    <p class="hero-subtitle">Kelola dan pantau usulan pelatihan Anda dengan mudah dan efisien</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.nomenklatur') }}" class="btn btn-elegant btn-secondary">
                        <i class="bi bi-list-ul me-2"></i>
                        <span>Lihat Nomenklatur</span>
                    </a>
                    <a href="{{ route('pelatihan.usulan.create') }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        <span>Tambah Usulan Baru</span>
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
                <h6 class="info-title">Informasi Penting</h6>
                <p class="info-text">
                    Anda hanya dapat mengedit atau menghapus usulan dengan status <span class="status-highlight status-saved">"Tersimpan"</span>. 
                    Usulan yang sudah <span class="status-highlight status-processed">"Tercetak"</span>, 
                    <span class="status-highlight status-sent">"Terkirim"</span>, 
                    <span class="status-highlight status-accepted">"Diterima"</span>, atau 
                    <span class="status-highlight status-rejected">"Ditolak"</span> tidak dapat diubah.
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
                </div>
                <form method="GET" action="{{ route('pelatihan.usulan.index') }}" id="filterForm" class="modern-form">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label class="filter-label">Status Verifikasi</label>
                            <div class="select-wrapper">
                                <select name="status" class="modern-select">
                                    <option value="">🔍 Semua Status</option>
                                    <option value="tersimpan" {{ request('status') == 'tersimpan' ? 'selected' : '' }}>
                                        📝 Tersimpan
                                    </option>
                                    <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>
                                        📤 Terkirim
                                    </option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                        ✅ Diterima
                                    </option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                        ❌ Ditolak
                                    </option>
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">Periode Pelatihan</label>
                            <div class="select-wrapper">
                                <select name="periode" class="modern-select">
                                    <option value="">📅 Semua Periode</option>
                                    <option value="current" {{ request('periode') == 'current' ? 'selected' : '' }}>
                                        🗓️ Tahun Ini ({{ date('Y') }})
                                    </option>
                                    <option value="next" {{ request('periode') == 'next' ? 'selected' : '' }}>
                                        ⏭️ Tahun Depan ({{ date('Y') + 1 }})
                                    </option>
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="filter-group search-group">
                            <label class="filter-label">Cari Pelatihan</label>
                            <div class="search-wrapper">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" name="search" class="modern-search" 
                                    placeholder="Cari nama pelatihan, jenis, atau metode..." 
                                    value="{{ request('search') }}">
                                @if(request('search'))
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
                @if($pendaftarans->count() > 0)
                    <div class="data-table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th class="col-number">No</th>
                                    <th class="col-training">Detail Pelatihan</th>
                                    <th class="col-status">Status</th>
                                    <th class="col-schedule">Jadwal</th>
                                    <th class="col-actions">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftarans as $item)
                                    <tr class="table-row" data-status="{{ $item->status_verifikasi }}">
                                        <td class="col-number">
                                            <span class="row-number">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="col-training">
                                            <div class="training-info">
                                                <h6 class="training-title">
                                                    {{ $item->usulan->nama_pelatihan ?? 'Nama pelatihan tidak tersedia' }}
                                                </h6>
                                                <div class="training-meta">
                                                    <span class="meta-badge badge-type">
                                                        <i class="bi bi-tag-fill me-1"></i>
                                                        {{ $item->usulan->jenispelatihan->jenis_pelatihan ?? 'Jenis tidak tersedia' }}
                                                    </span>
                                                    <span class="meta-badge badge-method">
                                                        <i class="bi bi-gear-fill me-1"></i>
                                                        {{ $item->usulan->metodepelatihan->metode_pelatihan ?? 'Metode tidak tersedia' }}
                                                    </span>
                                                    <span class="meta-badge badge-implementation">
                                                        <i class="bi bi-calendar2-check-fill me-1"></i>
                                                        {{ $item->usulan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? 'Pelaksanaan tidak tersedia' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-status">
                                            <span class="status-badge status-{{ $item->status_verifikasi }}">
                                                @switch($item->status_verifikasi)
                                                    @case('tersimpan')
                                                        <i class="bi bi-save me-1"></i>
                                                        @break
                                                    @case('terkirim')
                                                        <i class="bi bi-send me-1"></i>
                                                        @break
                                                    @case('diterima')
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        @break
                                                    @case('tercetak')
                                                        <i class="bi bi-printer me-1"></i>
                                                        @break
                                                    @default
                                                        <i class="bi bi-x-circle me-1"></i>
                                                @endswitch
                                                {{ ucfirst($item->status_verifikasi) }}
                                            </span>
                                        </td>
                                        <td class="col-schedule">
                                            <div class="schedule-info">
                                                <div class="schedule-item">
                                                    <i class="bi bi-play-circle-fill text-success me-2"></i>
                                                    <span class="schedule-label">Mulai:</span>
                                                    <span class="schedule-date">{{ \Carbon\Carbon::parse($item->usulan->tanggal_mulai)->format('d M Y') }}</span>
                                                </div>
                                                <div class="schedule-item">
                                                    <i class="bi bi-stop-circle-fill text-danger me-2"></i>
                                                    <span class="schedule-label">Selesai:</span>
                                                    <span class="schedule-date">{{ \Carbon\Carbon::parse($item->usulan->tanggal_selesai)->format('d M Y') }}</span>
                                                </div>
                                                <div class="schedule-duration">
                                                    <i class="bi bi-clock-fill me-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->usulan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($item->usulan->tanggal_selesai)) + 1 }} hari
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-actions">
                                            <div class="action-buttons">
                                                <a href="{{ route('pelatihan.usulan.show', $item->id) }}" 
                                                   class="action-btn btn-view" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat Detail">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                @if ($item->status_verifikasi === 'tersimpan')
                                                    <a href="{{ route('pelatihan.usulan.edit', $item->id) }}" 
                                                       class="action-btn btn-edit" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Usulan">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="action-btn btn-delete" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalHapus{{ $item->id }}"
                                                            title="Hapus Usulan">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                @else
                                                    <button class="action-btn btn-disabled" 
                                                            disabled 
                                                            data-bs-toggle="tooltip"
                                                            title="Tidak dapat edit - Status: {{ ucfirst($item->status_verifikasi) }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button class="action-btn btn-disabled" 
                                                            disabled 
                                                            data-bs-toggle="tooltip"
                                                            title="Tidak dapat hapus - Status: {{ ucfirst($item->status_verifikasi) }}">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Enhanced Delete Modal -->
                                    <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modern-modal">
                                                <div class="modal-header">
                                                    <div class="modal-icon">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                    </div>
                                                    <div class="modal-title-section">
                                                        <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                                                        <p class="modal-subtitle">Tindakan ini tidak dapat dibatalkan</p>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="confirmation-text">
                                                        Apakah Anda yakin ingin menghapus usulan pelatihan:
                                                    </p>
                                                    <div class="item-to-delete">
                                                        <strong>{{ $item->usulan->nama_pelatihan ?? 'Usulan ini' }}</strong>
                                                    </div>
                                                    <p class="warning-text">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        Data yang sudah dihapus tidak dapat dikembalikan.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-elegant btn-secondary" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle me-2"></i>Batal
                                                    </button>
                                                    <form action="{{ route('pelatihan.usulan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-elegant btn-danger">
                                                            <i class="bi bi-trash3-fill me-2"></i>Ya, Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <h5 class="empty-title">Belum Ada Usulan Pelatihan</h5>
                        <p class="empty-text">
                            Anda belum memiliki usulan pelatihan. Mulai tambahkan usulan pelatihan pertama Anda.
                        </p>
                        <a href="{{ route('pelatihan.usulan.create') }}" class="btn btn-elegant btn-primary">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Tambah Usulan Pertama
                        </a>
                    </div>
                @endif
            </div>
            <!-- Enhanced Pagination and Info -->
            @if($pendaftarans->count() > 0)
                <div class="pagination-section">
                    <div class="pagination-info">
                        <div class="info-text">
                            <span class="showing-text">Menampilkan</span>
                            <span class="pagination-numbers">
                                <strong>{{ $pendaftarans->firstItem() }}</strong> - 
                                <strong>{{ $pendaftarans->lastItem() }}</strong>
                            </span>
                            <span class="of-text">dari</span>
                            <span class="total-number">
                                <strong>{{ $pendaftarans->total() }}</strong>
                            </span>
                            <span class="entries-text">entri</span>
                        </div>
                    </div>
                    <div class="pagination-controls">
                        {{ $pendaftarans->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

<!-- Enhanced JavaScript for Filter -->
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto submit form when filter changes
            const filterForm = document.getElementById('filterForm');
            const filterSelects = filterForm.querySelectorAll('select');

            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    filterForm.submit();
                });
            });

            // Handle search input with debounce
            const searchInput = filterForm.querySelector('input[name="search"]');
            let searchTimer;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add loading state to forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
                    }
                });
            });
        });

        // Clear search function
        function clearSearch() {
            const searchInput = document.querySelector('input[name="search"]');
            const form = document.getElementById('filterForm');
            searchInput.value = '';
            form.submit();
        }
    </script>
@endsection
{{-- <script>
    @if (session('success'))
        var myModal = new bootstrap.Modal(document.getElementById('modalSuccess'));
        myModal.show();
    @endif
</script> --}}
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
            max-width: 1400px;
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
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
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        /* Info Card */
        .info-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border-left: 4px solid var(--info-soft);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            background: var(--info-soft);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .info-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            color: var(--dark-soft);
        }

        .info-text {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .status-highlight {
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-saved { background: rgba(168, 168, 168, 0.2); color: var(--secondary-soft); }
        .status-processed { background: rgba(255, 224, 130, 0.2); color: #d97706; }
        .status-sent { background: rgba(139, 157, 195, 0.2); color: var(--primary-soft); }
        .status-accepted { background: rgba(165, 214, 167, 0.2); color: #059669; }
        .status-rejected { background: rgba(239, 154, 154, 0.2); color: #dc2626; }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .filter-header {
            margin-bottom: 1.5rem;
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-soft);
            margin: 0;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark-soft);
            margin-bottom: 0.5rem;
        }

        .select-wrapper, .search-wrapper {
            position: relative;
        }

        .modern-select, .modern-search {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: var(--border-radius-sm);
            background: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            appearance: none;
        }

        .modern-select:focus, .modern-search:focus {
            outline: none;
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
        }

        .select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-soft);
            pointer-events: none;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-soft);
        }

        .modern-search {
            padding-left: 3rem;
            padding-right: 3rem;
        }

        .clear-search {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-soft);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .clear-search:hover {
            color: var(--danger-soft);
        }

        /* Table Section */
        .table-section {
            padding: 0;
        }

        .data-table-wrapper {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 1.5rem 1rem;
            font-weight: 600;
            color: var(--dark-soft);
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-row {
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .modern-table td {
            padding: 1.5rem 1rem;
            vertical-align: top;
        }

        /* Column Styles */
        .col-number {
            width: 80px;
            text-align: center;
        }

        .row-number {
            background: var(--gradient-primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .col-training {
            min-width: 300px;
        }

        .training-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-soft);
            margin: 0 0 0.75rem 0;
            line-height: 1.4;
        }

        .training-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .meta-badge {
            padding: 0.4rem 0.8rem;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-type { background: rgba(139, 157, 195, 0.1); color: var(--primary-soft); }
        .badge-method { background: rgba(165, 214, 167, 0.1); color: #059669; }
        .badge-implementation { background: rgba(179, 229, 252, 0.1); color: #0891b2; }

        .col-status {
            width: 150px;
        }

        .status-badge {
            padding: 0.6rem 1rem;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: capitalize;
        }

        .status-tersimpan { background: rgba(168, 168, 168, 0.15); color: var(--secondary-soft); }
        .status-terkirim { background: rgba(139, 157, 195, 0.15); color: var(--primary-soft); }
        .status-diterima { background: rgba(165, 214, 167, 0.15); color: #059669; }
        .status-tercetak { background: rgba(255, 224, 130, 0.15); color: #d97706; }
        .status-ditolak { background: rgba(239, 154, 154, 0.15); color: #dc2626; }

        .col-schedule {
            width: 200px;
        }

        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .schedule-label {
            font-weight: 500;
            color: var(--secondary-soft);
        }

        .schedule-date {
            color: var(--dark-soft);
            font-weight: 600;
        }

        .schedule-duration {
            background: rgba(139, 157, 195, 0.1);
            color: var(--primary-soft);
            padding: 0.3rem 0.6rem;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            align-self: flex-start;
        }

        .col-actions {
            width: 180px;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-view { background: rgba(179, 229, 252, 0.2); color: #0891b2; }
        .btn-edit { background: rgba(139, 157, 195, 0.2); color: var(--primary-soft); }
        .btn-delete { background: rgba(239, 154, 154, 0.2); color: #dc2626; }
        .btn-disabled { background: rgba(168, 168, 168, 0.1); color: var(--secondary-soft); cursor: not-allowed; }

        .btn-view:hover { background: #0891b2; color: white; transform: translateY(-2px); }
        .btn-edit:hover { background: var(--primary-soft); color: white; transform: translateY(-2px); }
        .btn-delete:hover { background: #dc2626; color: white; transform: translateY(-2px); }

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
            background: var(--gradient-primary);
            color: white;
        }

        .btn-elegant.btn-secondary {
            background: var(--gradient-secondary);
            color: white;
        }

        .btn-elegant.btn-outline-secondary {
            border: 2px solid #fff;
            color: white;
        }

        .btn-elegant.btn-danger {
            background: var(--gradient-danger);
            color: white;
        }

        .btn-elegant:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--secondary-soft);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-soft);
        }

        .empty-text {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: var(--secondary-soft);
        }

        /* Modern Modal */
        .modern-modal .modal-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e5e7eb;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            background: rgba(239, 154, 154, 0.2);
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-icon i {
            font-size: 1.5rem;
            color: #dc2626;
        }

        .modal-title-section .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: var(--dark-soft);
        }

        .modal-subtitle {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            margin: 0.25rem 0 0 0;
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .confirmation-text {
            font-size: 1rem;
            color: var(--dark-soft);
            margin-bottom: 1rem;
        }

        .item-to-delete {
            background: rgba(239, 154, 154, 0.1);
            padding: 1rem;
            border-radius: var(--border-radius-sm);
            border-left: 4px solid var(--danger-soft);
            margin-bottom: 1rem;
        }

        .warning-text {
            font-size: 0.9rem;
            color: var(--secondary-soft);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modern-modal .modal-footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 2rem;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* Pagination Section */
        .pagination-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info .info-text {
            color: var(--secondary-soft);
            font-size: 0.95rem;
        }

        .pagination-numbers, .total-number {
            color: var(--primary-soft);
            font-weight: 600;
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

            .hero-actions {
                flex-direction: column;
                width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .data-table-wrapper {
                margin: 0 -1rem;
            }

            .modern-table th, .modern-table td {
                padding: 1rem 0.5rem;
                font-size: 0.9rem;
            }

            .training-meta {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }

            .pagination-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        /* Animation for loading states */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Custom scrollbar */
        .data-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .data-table-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .data-table-wrapper::-webkit-scrollbar-thumb {
            background: var(--primary-soft);
            border-radius: 4px;
        }

        .data-table-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }
    </style>
@endsection
