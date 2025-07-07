@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Nama Pelatihan')
@section('page-title', 'Nama Pelatihan')

@section('additional-css')
    <style>
        .required-label::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

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

        .badge-success {
            background-color: #50cd89;
            color: #fff;
        }

        .badge-danger {
            background-color: #f1416c;
            color: #fff;
        }

        .badge-info {
            background-color: #7239ea;
            color: #fff;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
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
        <div class="card-header border-0 py-3 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari nama pelatihan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Filter Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'nip', 'kode', 'nama', 'jenis', 'status', 'tanggal', 'keterangan', 'aksi'] as $col)
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
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
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
                                        <label class="form-label small fw-semibold">Status</label>
                                        <select name="status" id="filter-status" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
                                            <option value="proses">Proses</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Baris Kedua -->
                                <div class="row g-3">
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
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-reset-filter" class="btn btn-md btn-outline-danger">
                        <i class="bi bi-eraser me-1"></i>Reset
                    </button>
                </div>

                <!-- Tombol Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <a href="{{ route('dashboard.pelatihan.nomenklaturadmin.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Usul Nomenklatur
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pelatihan.nomenklaturadmin._table', [
                    'namapelatihans' => $namapelatihans,
                ])
            </div>
        </div>

        <div class="card-footer px-5 py-3" id="pagination-wrapper">
            {{ $namapelatihans->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.nomenklaturadmin.script')
@endsection
