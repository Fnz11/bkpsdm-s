<!-- Modal PDF -->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true"
    style="z-index: 1501;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('dashboard.pelatihan.rekapitulasi.cetak-pdf') }}" method="GET" target="_blank"
            id="form-cetak-pdf">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-semibold">Cetak PDF Rekapitulasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Progress Bar -->
                    <div
                        class="d-flex justify-content-between align-items-center position-relative mb-4 step-progress-pdf">
                        <!-- STEP 1 -->
                        <div class="step-item text-center d-flex flex-column align-items-center" data-step="1">
                            <div class="step-dot">
                                <div class="dot-circle"></div>
                            </div>
                            <div class="step-title mt-2">Jenis Rekap</div>
                        </div>
                        
                        <!-- STEP 2 -->
                        <div class="step-item text-center d-flex flex-column align-items-center" data-step="2">
                            <div class="step-dot">
                                <div class="dot-circle"></div>
                            </div>
                            <div class="step-title mt-2">Filter Data</div>
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

                        <div class="progress-line-pdf"></div>
                    </div>

                    <!-- STEP 1: JENIS REKAP -->
                    <div id="step-jenis-rekap" class="step-content d-none" data-step="1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Pilih Jenis Rekapitulasi</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="jenis_rekap"
                                        id="rekap-pelatihan" value="pelatihan" checked>
                                    <label class="form-check-label" for="rekap-pelatihan">
                                        Rekap per Pelatihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_rekap" id="rekap-opd"
                                        value="opd">
                                    <label class="form-check-label" for="rekap-opd">
                                        Rekap per OPD
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: FILTER -->
                    <div id="step-filter-pdf" class="step-content active" data-step="2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="filter-modal-search-pdf" class="form-label fw-semibold">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="filter-modal-search-pdf" class="form-control"
                                        placeholder="Cari...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rentang Tanggal</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Dari</span>
                                            <input type="date" id="filter-modal-start-date-pdf" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Sampai</span>
                                            <input type="date" id="filter-modal-end-date-pdf" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Data Section -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-semibold mb-0">Pratinjau Data</h6>
                                <div id="preview-data-count-pdf" class="text-muted small d-none">
                                    <span id="count-total-pdf" class="fw-bold text-primary">0</span> data terpilih
                                </div>
                            </div>

                            <div id="preview-data-wrapper-pdf" class="card border d-none">
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 300px;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="table-light position-sticky top-0">
                                                <tr>
                                                    <th>Jenis Rekap</th>
                                                    <th>Nama</th>
                                                    <th>Jumlah Pendaftar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="preview-data-body-pdf" class="font-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="preview-empty-pdf" class="text-center py-4 bg-light rounded">
                                <i class="bi bi-database-exclamation fs-3 text-muted"></i>
                                <p class="mt-2 mb-0 text-muted">Gunakan filter untuk menampilkan data</p>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: PDF SETTINGS -->
                    <div id="step-pdf-settings" class="step-content d-none" data-step="3">
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
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="show_header"
                                                id="show_header" checked>
                                            <label class="form-check-label" for="show_header">
                                                Tampilkan Header
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="show_footer"
                                                id="show_footer" checked>
                                            <label class="form-check-label" for="show_footer">
                                                Tampilkan Footer
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: KONFIRMASI -->
                    <div id="step-konfirmasi-pdf" class="step-content d-none" data-step="4">
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
                                                    <td>: <span id="summary-search-pdf">-</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Rentang Tanggal</td>
                                                    <td>: <span id="summary-date-pdf">-</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Data</td>
                                                    <td>: <span id="summary-count-pdf" class="fw-bold">0</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold text-primary">Pengaturan</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="140">Jenis Rekap</td>
                                                    <td>: <span id="summary-jenis-rekap">Per Pelatihan</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Ukuran Kertas</td>
                                                    <td>: <span id="summary-paper-size">A4</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Orientasi</td>
                                                    <td>: <span id="summary-orientation">Portrait</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirm-check-pdf">
                                        <label class="form-check-label" for="confirm-check-pdf">
                                            Saya telah memeriksa data dan memastikan semuanya benar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Filter -->
                    <input type="hidden" name="search" id="input-search-pdf">
                    <input type="hidden" name="start_date" id="input-start-date-pdf">
                    <input type="hidden" name="end_date" id="input-end-date-pdf">
                </div>

                <div class="modal-footer bg-light justify-content-between">
                    <div>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btn-batal-pdf"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btn-prev-step-pdf">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary d-none" id="btn-next-step-pdf">
                            Lanjut <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                        <button type="submit" class="btn btn-danger d-none" id="btn-submit-pdf" disabled>
                            <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Progress Steps */
    .step-progress-pdf {
        position: relative;
        margin-bottom: 2rem;
    }

    .step-item {
        position: relative;
        z-index: 2;
        flex: 1;
        min-width: 80px;
    }

    .progress-line-pdf {
        position: absolute;
        top: 15px;
        left: 30px;
        right: 30px;
        height: 3px;
        background-color: #e9ecef;
        z-index: 1;
    }

    .progress-line-pdf::before {
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
    .step-progress-pdf[data-step="1"] .progress-line-pdf::before {
        width: 25%;
    }

    .step-progress-pdf[data-step="2"] .progress-line-pdf::before {
        width: 50%;
    }

    .step-progress-pdf[data-step="3"] .progress-line-pdf::before {
        width: 75%;
    }

    .step-progress-pdf[data-step="4"] .progress-line-pdf::before {
        width: 100%;
    }

    .progress-line-pdf.active {
        background-color: var(--bs-primary);
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
