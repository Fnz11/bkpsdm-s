@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Data Alumni')
@section('page-title', 'Data Alumni')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Alumni</li>
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
                            placeholder="Cari pelatihan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Filter Kolom -->
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
                                    'uk' => 'Unit Kerja',
                                    'nama' => 'Nama Pelatihan',
                                    'tanggal' => 'Tanggal Daftar',
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
                            aria-expanded="false" data-bs-auto-close="outside" id="filterDropdownButton" aria-haspopup="true">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 600px;"
                            aria-labelledby="filterDropdownButton">
                            <div class="container-fluid">
                                <!-- Baris Pertama -->
                                <div class="row g-2 mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Unit Kerja</label>
                                        @if (auth()->user()->hasRole('admin'))
                                            {{-- Non-editable untuk admin --}}
                                            <select class="form-select form-select-md" disabled>
                                                @foreach ($unitkerjas as $unit)
                                                    @if ($unit->id == auth()->user()->latestUserPivot->unitKerja->unitkerja_id)
                                                        <option value="{{ $unit->id }}" selected>{{ $unit->unitkerja }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            {{-- Hidden input agar tetap terkirim --}}
                                            <input type="hidden" name="unit" id="filter-unit"
                                                value="{{ auth()->user()->latestUserPivot->unitKerja->unitkerja_id }}">
                                        @else
                                            {{-- Bisa pilih unit jika bukan admin --}}
                                            <select name="unit" id="filter-unit"
                                                class="form-select form-select-md select2">
                                                <option value="">Semua</option>
                                                @foreach ($unitkerjas as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                                @endforeach
                                            </select>
                                        @endif
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
                                            <i class="bi bi-eraser me-1"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <button type="button" class="btn btn-outline-success border border-success" data-bs-toggle="modal"
                        data-bs-target="#modalExcel">
                        <i class="bi bi-file-earmark-excel me-1"></i> Cetak Excel
                    </button>
                    <!-- Tombol buka modal cetak -->
                    <button type="button" class="btn btn-outline-danger border border-danger" data-bs-toggle="modal"
                        data-bs-target="#modalCetak">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pelatihan.alumni._table', ['alumnis' => $alumnis])
            </div>
        </div>

        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $alumnis->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('dashboard.pelatihan.alumni.modal-cetak')
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.alumni.script')
@endsection
