@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Laporan Pelatihan')
@section('page-title', 'Laporan Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Pelatihan</li>
    </ol>
@endsection

@section('additional-css')
    <style>
        .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            display: none;
        }

        .clear-search:hover {
            color: #495057;
        }

        .has-clear .form-control {
            padding-right: 2.5rem !important;
        }

        .w-md-250px {
            width: 250px !important;
        }

        .ps-10 {
            padding-left: 2.75rem !important;
        }

        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        .form-control-solid:focus {
            background-color: #eef3f7;
            border-color: #eef3f7;
        }

        .dropdown-menu label {
            cursor: pointer;
            width: 100%;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .w-md-250px {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="card border-0 shadow-sm p-3">
        <div class="card-header border-0 py-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari laporan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle border border-secondary" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'nama', 'judul', 'latar', 'hasil', 'biaya', 'laporan', 'sertifikat', 'aksi'] as $col)
                                <li>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="me-2 toggle-col" data-target="{{ $col }}"
                                            checked>
                                        {{ ucfirst($col) }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Dropdown Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle border border-primary" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 600px;">
                            <div class="container-fluid">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Jenis</label>
                                        <select name="jenis" id="filter-jenis" class="form-select">
                                            <option value="">Semua</option>
                                            @foreach ($jenispelatihans as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Status</label>
                                        <select name="status" id="filter-status" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="revisi">Revisi</option>
                                            <option value="lulus">Lulus</option>
                                            <option value="tidak lulus">Tidak Lulus</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tanggal Mulai</label>
                                        <input type="date" id="filter-start-date" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tanggal Selesai</label>
                                        <input type="date" id="filter-end-date" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 d-grid">
                                        <button type="button" id="btn-reset-filter"
                                            class="btn btn-outline-danger btn-md w-100">
                                            <i class="bi bi-eraser me-1"></i> Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <button type="button" class="btn btn-outline-primary border border-primary" data-bs-toggle="modal"
                        data-bs-target="#modalUpdateBulkLaporan">
                        <i class="bi bi-pencil-square me-1"></i> Update Status
                    </button>
                    <button type="button" class="btn btn-outline-success border border-success" data-bs-toggle="modal"
                        data-bs-target="#modalExcel">
                        <i class="bi bi-file-earmark-excel me-1"></i> Cetak Excel
                    </button>
                    <button type="button" class="btn btn-outline-danger border border-danger" data-bs-toggle="modal"
                        data-bs-target="#modalCetak">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    @include('dashboard.pelatihan.laporan._table', [
                        'laporans' => $laporans,
                    ])
                </table>
            </div>

            <div id="loading-spinner" class="text-center py-3 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div class="card-footer px-5 py-3" id="pagination-wrapper">
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('dashboard.pelatihan.laporan.modal-cetak')
    @include('dashboard.pelatihan.laporan.modal-update')
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.laporan.script')
    @include('dashboard.pelatihan.laporan.script-update')
@endsection
