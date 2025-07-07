@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Rekap Pendaftaran Pelatihan')
@section('page-title', 'Rekap Pendaftaran Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Rekap Pendaftaran Pelatihan</li>
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

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
        }

        .table-view-toggle {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .table-view-toggle .btn {
            flex: 1;
            padding: 0.75rem;
            font-weight: 600;
        }

        .col-no {
            width: 60px;
        }

        .col-jumlah {
            width: 240px;
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
                            placeholder="Cari...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Rentang Tanggal -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" id="filter-start-date" class="form-control form-control-md">
                        <span>s/d</span>
                        <input type="date" id="filter-end-date" class="form-control form-control-md">
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Tombol Cetak Excel -->
                    <button type="button" class="btn btn-outline-success border border-success" data-bs-toggle="modal"
                        data-bs-target="#modalExcel">
                        <i class="bi bi-file-earmark-excel me-1"></i> Cetak Excel
                    </button>

                    <!-- Tombol Cetak PDF -->
                    <button type="button" class="btn btn-outline-danger border border-danger" data-bs-toggle="modal" data-bs-target="#modalPdf">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <!-- View Toggle -->
            <div class="table-view-toggle">
                <input type="radio" class="btn-check" name="viewType" id="view-pelatihan" autocomplete="off" checked>
                <label class="btn btn-sm btn-outline-primary" for="view-pelatihan">Rekap per Pelatihan</label>

                <input type="radio" class="btn-check" name="viewType" id="view-opd" autocomplete="off">
                <label class="btn btn-sm btn-outline-primary border border-primary" for="view-opd">Rekap per OPD</label>
            </div>

            <!-- Pelatihan Table -->
            <div class="table-responsive" id="pelatihan-container">
                @include('dashboard.pelatihan.rekapitulasipendaftaran._pelatihan', [
                    'rekapPelatihan' => $rekapPelatihan,
                ])
            </div>

            <!-- OPD Table -->
            <div class="table-responsive d-none" id="opd-container">
                @include('dashboard.pelatihan.rekapitulasipendaftaran._opd', [
                    'rekapOPD' => $rekapOPD,
                ])
            </div>
        </div>
    </div>

    <!-- Modal Cetak PDF -->
    @include('dashboard.pelatihan.rekapitulasipendaftaran.modal-pdf')

    <!-- Modal Cetak Excel -->
    @include('dashboard.pelatihan.rekapitulasipendaftaran.modal-excel')
@endsection

@section('scripts')
    @include('dashboard.pelatihan.rekapitulasipendaftaran.script')
@endsection
