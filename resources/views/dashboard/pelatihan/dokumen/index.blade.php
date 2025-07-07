@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Dokumen Usulan Pelatihan')
@section('page-title', 'Dokumen Usulan Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Dokumen Usulan Pelatihan</li>
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
    <div class="card border-0 shadow-sm">
        @if (isset($deadline) && now()->gt($deadline->tanggal_deadline))
            <div class="alert alert-warning border-0 rounded-0 m-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <strong>Perhatian!</strong> Batas waktu upload dokumen telah lewat pada
                        {{ \Carbon\Carbon::parse($deadline->tanggal_deadline)->translatedFormat('d F Y') }}.
                        @if ($deadline->keterangan)
                            {{ $deadline->keterangan }}
                        @endif
                    </div>
                </div>
            </div>
        @elseif (isset($deadline))
            <div class="alert alert-info border-0 rounded-0 m-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>
                        <strong>Batas Waktu Upload Dokumen:</strong>
                        {{ \Carbon\Carbon::parse($deadline->tanggal_mulai)->translatedFormat('d F Y') }} s.d.
                        {{ \Carbon\Carbon::parse($deadline->tanggal_deadline)->translatedFormat('d F Y') }}.
                        @if ($deadline->keterangan)
                            {{ $deadline->keterangan }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="card-header border-0 p-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Filter Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle border border-secondary" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i> Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'opd', 'nama', 'file', 'upload', 'keterangan', 'status', 'aksi'] as $col)
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
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">OPD</label>
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
                                            <select name="unit" id="filter-unit" class="form-select form-select-md">
                                                <option value="">Semua</option>
                                                @foreach ($unitkerjas as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Status</label>
                                        <select name="status-verif" id="filter-status" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            <option value="menunggu">Menunggu</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
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

                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    @if (isset($deadline) && now()->gt($deadline->tanggal_deadline))
                        <small class="text-danger d-block">Upload dokumen sudah ditutup</small>
                    @else
                        <a href="{{ route('dashboard.pelatihan.dokumen.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Upload Dokumen
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pelatihan.dokumen._table', ['dokumens' => $dokumens])
            </div>
        </div>

        <div id="pagination-wrapper" class="px-5 py-3">
            {{ $dokumens->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.dokumen.script')
@endsection
