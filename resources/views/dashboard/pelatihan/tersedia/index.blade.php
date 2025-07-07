@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Pelatihan Tersedia')
@section('page-title', 'Pelatihan Tersedia')

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

        #filter-area {
            overflow-x: auto;
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

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><i class="bi bi-calendar-check"></i> Pelatihan Tersedia</li>
    </ol>
@endsection

@section('content')
    <div class="card border-0 shadow-sm p-3">
        <div class="card-header border-0 p-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 flex-wrap">
                <!-- Kiri: Pencarian & Filter Kolom -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 flex-wrap">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari pelatihan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Tampilkan Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle border border-secondary" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @php
                                $columns = [
                                    'no' => 'No',
                                    'nama' => 'Nama',
                                    'jenis' => 'Jenis',
                                    'metode' => 'Metode',
                                    'pelaksanaan' => 'Pelaksanaan',
                                    'penyelenggara' => 'Penyelenggara',
                                    'tempat' => 'Tempat',
                                    'tanggal' => 'Tanggal',
                                    'kuota' => 'Kuota',
                                    'biaya' => 'Biaya',
                                    'status' => 'Status',
                                    'aksi' => 'Aksi',
                                ];
                            @endphp
                            @foreach ($columns as $key => $label)
                                <li>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="me-2 toggle-col" data-target="{{ $key }}"
                                            checked>
                                        {{ $label }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Tombol Dropdown Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle border border-primary" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 600px;">
                            <div class="container-fluid">
                                <!-- Baris Pertama -->
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Jenis</label>
                                        <select name="jenis" id="filter-jenis" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($jenispelatihans as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Metode</label>
                                        <select name="metode" id="filter-metode" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($metodes as $metode)
                                                <option value="{{ $metode->id }}">{{ $metode->metode_pelatihan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Pelaksanaan</label>
                                        <select name="pelaksanaan" id="filter-pelaksanaan"
                                            class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($pelaksanaans as $pelaksanaan)
                                                <option value="{{ $pelaksanaan->id }}">
                                                    {{ $pelaksanaan->pelaksanaan_pelatihan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Baris Kedua -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Rentang Tanggal</label>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="date" id="filter-start-date"
                                                    class="form-control form-control-md" placeholder="Mulai">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" id="filter-end-date"
                                                    class="form-control form-control-md" placeholder="Selesai">
                                            </div>
                                        </div>
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

                <!-- Kanan: Update Status, & Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <form action="{{ route('dashboard.pelatihan.tersedia.updateStatus') }}" method="POST"
                        class="d-inline update-form">
                        @csrf
                        <button type="button" class="btn btn-outline-warning btn-md btn-update border border-warning">
                            <i class="bi bi-arrow-repeat me-1"></i> Update Status
                        </button>
                    </form>

                    <!-- Ekspor -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-success btn-md dropdown-toggle border border-success"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download me-1"></i> Ekspor
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                    data-bs-target="#modalExcel">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Cetak Excel
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalCetak">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                                </button>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('dashboard.pelatihan.tersedia.create') }}" class="btn btn-primary btn-md">
                        <i class="bi bi-plus-circle me-1"></i> Tambah
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    @include('dashboard.pelatihan.tersedia._table', ['pelatihans' => $pelatihans])
                </table>
            </div>

            <!-- Spinner Loading -->
            <div id="loading-spinner" class="text-center py-3 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer px-5 py-3" id="pagination-wrapper">
                {{ $pelatihans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @include('dashboard.pelatihan.tersedia.modal-cetak')
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.tersedia.script')
@endsection
