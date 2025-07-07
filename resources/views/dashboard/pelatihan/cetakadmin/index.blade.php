@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Cetak Usulan Pelatihan')

@section('additional-css')
    <style>
        /* Progress Steps */
        .step-progress {
            position: relative;
            margin-bottom: 2rem;
        }

        .step-item {
            position: relative;
            z-index: 2;
            flex: 1;
            min-width: 0;
        }

        .progress-line {
            position: absolute;
            top: 15px;
            left: 30px;
            right: 30px;
            height: 3px;
            background-color: #e9ecef;
            z-index: 1;
        }

        .progress-line.active {
            background-color: var(--bs-primary);
        }

        .progress-line::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background-color: var(--bs-primary);
            transition: width 0.3s ease;
        }

        /* Progress line fill based on current step */
        .step-progress[data-step="1"] .progress-line::before {
            width: 25%;
        }

        .step-progress[data-step="2"] .progress-line::before {
            width: 50%;
        }

        .step-progress[data-step="3"] .progress-line::before {
            width: 75%;
        }

        .step-progress[data-step="4"] .progress-line::before {
            width: 100%;
        }

        .step-dot {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 auto;
        }

        .dot-circle {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #e9ecef;
            transition: all 0.3s ease;
        }

        .step-item.active .dot-circle {
            background-color: var(--bs-primary);
            transform: scale(1.2);
        }

        .step-item.completed .dot-circle {
            background-color: var(--bs-primary);
        }

        .step-item.completed::after {
            content: "✓";
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 10px;
            font-weight: bold;
            z-index: 3;
        }

        .step-title {
            font-size: 0.85rem;
            color: #6c757d;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .step-item.active .step-title,
        .step-item.completed .step-title {
            color: var(--bs-primary);
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .step-title {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .step-title {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0 p-2 fw-semibold"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Pendaftaran PDF
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('dashboard.pelatihan.pendaftaran.cetak-pdf-admin') }}" method="GET"
                            target="_blank" id="form-cetak">
                            @csrf

                            <!-- Progress Bar -->
                            <div
                                class="d-flex justify-content-between align-items-center position-relative mb-4 step-progress">
                                <!-- STEP 1 -->
                                <div class="step-item text-center d-flex flex-column align-items-center" data-step="1">
                                    <div class="step-dot">
                                        <div class="dot-circle"></div>
                                    </div>
                                    <div class="step-title mt-2">Filter Data</div>
                                </div>

                                <!-- STEP 2 -->
                                <div class="step-item text-center d-flex flex-column align-items-center" data-step="2">
                                    <div class="step-dot">
                                        <div class="dot-circle"></div>
                                    </div>
                                    <div class="step-title mt-2">Penanggung Jawab</div>
                                </div>

                                <!-- STEP 3 -->
                                <div class="step-item text-center d-flex flex-column align-items-center" data-step="3">
                                    <div class="step-dot">
                                        <div class="dot-circle"></div>
                                    </div>
                                    <div class="step-title mt-2">Format PDF</div>
                                </div>

                                <!-- STEP 4 -->
                                <div class="step-item text-center d-flex flex-column align-items-center" data-step="4">
                                    <div class="step-dot">
                                        <div class="dot-circle"></div>
                                    </div>
                                    <div class="step-title mt-2">Konfirmasi</div>
                                </div>

                                <!-- Progress Line -->
                                <div class="progress-line"></div>
                            </div>

                            <!-- STEP 1: FILTER -->
                            <div id="step-filter" class="step-content active" data-step="1">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="filter-search" class="form-label fw-semibold">Pencarian</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="filter-search" class="form-control"
                                                placeholder="Cari NIP / Nama / Pelatihan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="filter-unit" class="form-label fw-semibold">Unit Kerja</label>
                                        @if (auth()->user()->hasRole('admin'))
                                            <select name="unit" class="form-select" id="filter-unit" disabled>
                                                @foreach ($unitkerjas as $unit)
                                                    @if ($unit->id == auth()->user()->latestUserPivot->unitKerja->unitkerja_id)
                                                        <option value="{{ $unit->id }}" selected>{{ $unit->unitkerja }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select name="unit" id="filter-unit" class="form-select">
                                                <option value="">Semua Unit Kerja</option>
                                                @foreach ($unitkerjas as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Rentang Tanggal Pendaftaran</label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">Dari</span>
                                                    <input type="date" id="filter-start-date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">Sampai</span>
                                                    <input type="date" id="filter-end-date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Data Section -->
                                <div class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-semibold mb-0">Pratinjau Data</h6>
                                        <div id="preview-data-count" class="text-muted small d-none">
                                            <span id="count-total" class="fw-bold text-primary">0</span> data terpilih
                                        </div>
                                    </div>

                                    <div id="preview-data-wrapper" class="card border d-none">
                                        <div class="card-body p-0">
                                            <div class="table-responsive" style="max-height: 300px;">
                                                <table class="table table-sm table-hover table-striped mb-0">
                                                    <thead class="table-light position-sticky top-0">
                                                        <tr>
                                                            <th width="120">NIP</th>
                                                            <th>Nama</th>
                                                            <th>Pelatihan</th>
                                                            <th>Unit Kerja</th>
                                                            <th width="120">Jenis</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="preview-data-body" class="font-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="preview-empty" class="text-center py-4 bg-light rounded">
                                        <i class="bi bi-database-exclamation fs-3 text-muted"></i>
                                        <p class="mt-2 mb-0 text-muted">Gunakan filter untuk menampilkan data</p>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2: PENANGGUNG JAWAB -->
                            <div id="step-penanggungjawab" class="step-content d-none mt-4" data-step="2">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Mode Penanggung Jawab</h6>
                                        <div class="mb-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="mode_penanggung"
                                                    id="penanggung-otomatis" value="otomatis" checked>
                                                <label class="form-check-label" for="penanggung-otomatis">Otomatis (Atasan
                                                    Anda)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="mode_penanggung"
                                                    id="penanggung-manual" value="manual">
                                                <label class="form-check-label" for="penanggung-manual">Input
                                                    Manual</label>
                                            </div>
                                        </div>

                                        <div id="penanggung-fields" class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Nama Penanggung Jawab</label>
                                                <input type="text" name="penanggungjawab_nama"
                                                    id="penanggungjawab_nama" class="form-control"
                                                    placeholder="Nama lengkap" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">NIP</label>
                                                <input type="text" name="penanggungjawab_nip" id="penanggungjawab_nip"
                                                    class="form-control" placeholder="Nomor induk pegawai" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Jabatan</label>
                                                <input type="text" name="penanggungjawab_jabatan"
                                                    id="penanggungjawab_jabatan" class="form-control"
                                                    placeholder="Jabatan struktural" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Pangkat/Golongan</label>
                                                <input type="text" name="penanggungjawab_pangkat"
                                                    id="penanggungjawab_pangkat" class="form-control"
                                                    placeholder="Pangkat dan golongan" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3: PDF SETTINGS -->
                            <div id="step-pdf-settings" class="step-content d-none mt-4" data-step="3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Pengaturan PDF</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Ukuran Kertas</label>
                                                <select name="paper_size" class="form-select">
                                                    <option value="a4">A4</option>
                                                    <option value="legal">Legal</option>
                                                    <option value="letter">Letter</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Orientasi</label>
                                                <select name="orientation" class="form-select">
                                                    <option value="portrait">Portrait</option>
                                                    <option value="landscape">Landscape</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Margin (inci)</label>
                                                <div class="row g-2">
                                                    <div class="col-3">
                                                        <input type="number" name="margin_top" class="form-control"
                                                            placeholder="Atas" value="0.5" step="0.1">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" name="margin_right" class="form-control"
                                                            placeholder="Kanan" value="0.5" step="0.1">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" name="margin_bottom" class="form-control"
                                                            placeholder="Bawah" value="0.5" step="0.1">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" name="margin_left" class="form-control"
                                                            placeholder="Kiri" value="0.5" step="0.1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 4: KONFIRMASI -->
                            <div id="step-konfirmasi" class="step-content d-none" data-step="4">
                                <div class="alert alert-primary d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                    <div>Periksa kembali data yang akan dicetak sebelum melanjutkan</div>
                                </div>

                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold border-bottom pb-2 mb-3">Ringkasan Data</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold text-primary">Filter Data</h6>
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <td width="140">Pencarian</td>
                                                            <td>: <span id="summary-search">-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td>: <span id="summary-unit">Semua</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rentang Tanggal</td>
                                                            <td>: <span id="summary-date">-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah Data</td>
                                                            <td>: <span id="summary-count" class="fw-bold">0</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold text-primary">Penanggung Jawab</h6>
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <td width="140">Nama</td>
                                                            <td>: <span id="summary-pj-nama">-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>NIP</td>
                                                            <td>: <span id="summary-pj-nip">-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>: <span id="summary-pj-jabatan">-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pangkat</td>
                                                            <td>: <span id="summary-pj-pangkat">-</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold text-primary">Pengaturan PDF</h6>
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <td width="140">Ukuran Kertas</td>
                                                            <td>: <span id="summary-paper-size">A4</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Orientasi</td>
                                                            <td>: <span id="summary-orientation">Portrait</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Margin</td>
                                                            <td>: <span id="summary-margins">10mm (atas), 10mm (kanan),
                                                                    10mm (bawah), 10mm (kiri)</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="confirm-check">
                                                <label class="form-check-label" for="confirm-check">
                                                    Saya telah memeriksa data dan memastikan semuanya benar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden Filter -->
                            <input type="hidden" name="search" id="input-search">
                            <input type="hidden" name="unit_id" id="input-unit">
                            <input type="hidden" name="start_date" id="input-start-date">
                            <input type="hidden" name="end_date" id="input-end-date">
                            <input class="form-check-input d-none" type="checkbox" name="show_header" id="show_header"
                                checked>
                            <input class="form-check-input d-none" type="checkbox" name="show_footer" id="show_footer">
                            <input class="form-check-input d-none" type="checkbox" name="show_signature"
                                id="show_signature" checked>

                            <!-- Navigation Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary d-none" id="btn-prev-step">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary d-none" id="btn-next-step">
                                        Lanjut <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger d-none" id="btn-submit-cetak" disabled>
                                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pelatihan.cetakadmin.script')
@endsection
