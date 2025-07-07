<!-- Modal -->
<div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true"
    style="z-index: 1501;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('dashboard.pelatihan.laporan.cetak-pdf') }}" method="GET" target="_blank" id="form-cetak">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-semibold">Cetak PDF Laporan Pelatihan</h5>
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
                            <div class="step-title mt-2">Filter Data</div>
                        </div>

                        <!-- STEP 2 -->
                        <div class="step-item text-center d-flex flex-column align-items-center" data-step="2">
                            <div class="step-dot">
                                <div class="dot-circle"></div>
                            </div>
                            <div class="step-title mt-2">Format PDF</div>
                        </div>

                        <!-- STEP 3 -->
                        <div class="step-item text-center d-flex flex-column align-items-center" data-step="3">
                            <div class="step-dot">
                                <div class="dot-circle"></div>
                            </div>
                            <div class="step-title mt-2">Konfirmasi</div>
                        </div>

                        <div class="progress-line"></div>
                    </div>

                    <!-- STEP 1: FILTER -->
                    <div id="step-filter" class="step-content active" data-step="1">
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="filter-modal-search" class="form-label fw-semibold">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="filter-modal-search" class="form-control"
                                        placeholder="Cari judul/latar belakang/nama pelatihan...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="filter-modal-jenis" class="form-label fw-semibold">Jenis Pelatihan</label>
                                <select name="jenis" id="filter-modal-jenis" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($jenispelatihans as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Hasil</label>
                                <select name="status" id="filter-modal-status" class="form-select form-select-md">
                                    <option value="">Semua</option>
                                    <option value="revisi">Revisi</option>
                                    <option value="lulus">Lulus</option>
                                    <option value="tidak lulus">Tidak Lulus</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Rentang Tanggal Laporan</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Dari</span>
                                            <input type="date" id="filter-modal-start-date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Sampai</span>
                                            <input type="date" id="filter-modal-end-date" class="form-control">
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
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="table-light position-sticky top-0">
                                                <tr>
                                                    <th>Nama Pelatihan</th>
                                                    <th>Judul</th>
                                                    <th>Latar Belakang</th>
                                                    <th>Total Biaya</th>
                                                    <th>Hasil</th>
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

                    <!-- STEP 2: PDF SETTINGS -->
                    <div id="step-pdf-settings" class="step-content d-none mt-4" data-step="2">
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

                    <!-- STEP 3: KONFIRMASI -->
                    <div id="step-konfirmasi" class="step-content d-none" data-step="3">
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
                                                    <td>Jenis Pelatihan</td>
                                                    <td>: <span id="summary-jenis">Semua</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Hasil</td>
                                                    <td>: <span id="summary-status">Semua</span></td>
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
                                                    <td>: <span id="summary-margins">10mm (atas), 10mm (kanan), 10mm
                                                            (bawah), 10mm (kiri)</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Header</td>
                                                    <td>: <span id="summary-header">Aktif</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Footer</td>
                                                    <td>: <span id="summary-footer">Aktif</span>
                                                    </td>
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
                    <input type="hidden" name="jenis" id="input-jenis">
                    <input type="hidden" name="status" id="input-status">
                    <input type="hidden" name="start_date" id="input-start-date">
                    <input type="hidden" name="end_date" id="input-end-date">
                </div>

                <div class="modal-footer bg-light justify-content-between">
                    <div>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btn-batal"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
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
            </div>
        </form>
    </div>
</div>

<!-- Modal Excel -->
<div class="modal fade" id="modalExcel" tabindex="-1" aria-labelledby="modalExcelLabel" aria-hidden="true"
    style="z-index: 1501;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('dashboard.pelatihan.laporan.cetak-excel') }}" method="GET" target="_blank"
            id="form-excel">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-semibold">Export Excel Laporan Pelatihan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Progress Bar -->
                    <div
                        class="d-flex justify-content-center align-items-center position-relative mb-4 gap-5 step-progress-excel">
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
                            <div class="step-title mt-2">Format Excel</div>
                        </div>

                        <!-- STEP 3 -->
                        <div class="step-item text-center d-flex flex-column align-items-center" data-step="3">
                            <div class="step-dot">
                                <div class="dot-circle"></div>
                            </div>
                            <div class="step-title mt-2">Konfirmasi</div>
                        </div>

                        <div class="progress-line"></div>
                    </div>

                    <!-- STEP 1: FILTER -->
                    <div id="step-filter-excel" class="step-content active" data-step="1">
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="filter-modal-search-excel"
                                    class="form-label fw-semibold">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="filter-modal-search-excel" class="form-control"
                                        placeholder="Cari judul/latar belakang/nama pelatihan...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="filter-modal-jenis-excel" class="form-label fw-semibold">Jenis
                                    Pelatihan</label>
                                <select name="jenis" id="filter-modal-jenis-excel" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($jenispelatihans as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Hasil</label>
                                <select name="status" id="filter-modal-status-excel"
                                    class="form-select form-select-md">
                                    <option value="">Semua</option>
                                    <option value="revisi">Revisi</option>
                                    <option value="lulus">Lulus</option>
                                    <option value="tidak lulus">Tidak Lulus</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Rentang Tanggal Laporan</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Dari</span>
                                            <input type="date" id="filter-modal-start-date-excel"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Sampai</span>
                                            <input type="date" id="filter-modal-end-date-excel"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Data Section -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-semibold mb-0">Pratinjau Data</h6>
                                <div id="preview-data-count-excel" class="text-muted small d-none">
                                    <span id="count-total-excel" class="fw-bold text-primary">0</span> data terpilih
                                </div>
                            </div>

                            <div id="preview-data-wrapper-excel" class="card border d-none">
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 300px;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="table-light position-sticky top-0">
                                                <tr>
                                                    <th>Nama Pelatihan</th>
                                                    <th>Judul</th>
                                                    <th>Latar Belakang</th>
                                                    <th>Total Biaya</th>
                                                    <th>Hasil</th>
                                                </tr>
                                            </thead>
                                            <tbody id="preview-data-body-excel" class="font-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="preview-empty-excel" class="text-center py-4 bg-light rounded">
                                <i class="bi bi-database-exclamation fs-3 text-muted"></i>
                                <p class="mt-2 mb-0 text-muted">Gunakan filter untuk menampilkan data</p>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: EXCEL SETTINGS -->
                    <div id="step-excel-settings" class="step-content d-none mt-4" data-step="2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Pengaturan Excel</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Format File</label>
                                        <select name="file_format" class="form-select">
                                            <option value="xlsx">Excel (.xlsx)</option>
                                            <option value="csv">CSV (.csv)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Include Header</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="include_header"
                                                id="include_header" checked>
                                            <label class="form-check-label" for="include_header">Sertakan Header
                                                Kolom</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Kolom yang Ditampilkan</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="judul" id="col_judul" checked>
                                                    <label class="form-check-label" for="col_judul">Judul</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="latar_belakang" id="col_latar" checked>
                                                    <label class="form-check-label" for="col_latar">Latar
                                                        Belakang</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="total_biaya" id="col_biaya" checked>
                                                    <label class="form-check-label" for="col_biaya">Total
                                                        Biaya</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="hasil_pelatihan" id="col_hasil" checked>
                                                    <label class="form-check-label" for="col_hasil">Hasil
                                                        Pelatihan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="created_at" id="col_tanggal" checked>
                                                    <label class="form-check-label" for="col_tanggal">Tanggal
                                                        Laporan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: KONFIRMASI -->
                    <div id="step-konfirmasi-excel" class="step-content d-none" data-step="3">
                        <div class="alert alert-primary d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                            <div>Periksa kembali data yang akan diexport sebelum melanjutkan</div>
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
                                                    <td>: <span id="summary-search-excel">-</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Pelatihan</td>
                                                    <td>: <span id="summary-jenis-excel">Semua</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Hasil</td>
                                                    <td>: <span id="summary-status-excel">Semua</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Rentang Tanggal</td>
                                                    <td>: <span id="summary-date-excel">-</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Data</td>
                                                    <td>: <span id="summary-count-excel" class="fw-bold">0</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold text-primary">Pengaturan Excel</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="140">Format File</td>
                                                    <td>: <span id="summary-format">Excel (.xlsx)</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Header Kolom</td>
                                                    <td>: <span id="summary-header">Ya</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Kolom Dipilih</td>
                                                    <td>: <span id="summary-columns">5 kolom</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirm-check-excel">
                                        <label class="form-check-label" for="confirm-check-excel">
                                            Saya telah memeriksa data dan memastikan semuanya benar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Filter -->
                    <input type="hidden" name="search" id="input-search-excel">
                    <input type="hidden" name="jenis" id="input-jenis-excel">
                    <input type="hidden" name="status" id="input-status-excel">
                    <input type="hidden" name="start_date" id="input-start-date-excel">
                    <input type="hidden" name="end_date" id="input-end-date-excel">
                </div>

                <div class="modal-footer bg-light justify-content-between">
                    <div>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btn-batal-excel"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btn-prev-step-excel">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary d-none" id="btn-next-step-excel">
                            Lanjut <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                        <button type="submit" class="btn btn-success d-none" id="btn-submit-excel" disabled>
                            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
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

    .step-progress-excel {
        position: relative;
        margin-bottom: 2rem;
    }

    .step-item {
        position: relative;
        z-index: 2;
        flex: 1;
        min-width: 80px;
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

    /* Position the lines between steps */
    /* Excel */
    .step-progress-excel[data-step="1"] .progress-line::before {
        width: 30%;
    }

    .step-progress-excel[data-step="2"] .progress-line::before {
        width: 70%;
    }

    .step-progress-excel[data-step="3"] .progress-line::before {
        width: 100%;
    }

    /* PDF */
    .step-progress-pdf[data-step="1"] .progress-line::before {
        width: 30%;
    }

    .step-progress-pdf[data-step="2"] .progress-line::before {
        width: 70%;
    }

    .step-progress-pdf[data-step="3"] .progress-line::before {
        width: 100%;
    }

    .progress-line.active {
        background-color: var(--bs-primary);
    }

    .step-dot {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
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
        font-size: 1rem;
        color: #6c757d;
        transition: all 0.3s ease;
        text-align: center;
        margin-top: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
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
            white-space: normal;
            word-break: break-word;
        }

        .step-item {
            min-width: 60px;
        }

        .progress-line {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .step-title {
            display: none;
        }
    }

    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.5rem + 2px);
        /* padding: 0.375rem 0.75rem; */
        font-size: 1rem;
        line-height: 1.5;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
        position: absolute;
        right: 1rem;
        top: 10%;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: #999;
        cursor: pointer;
        z-index: 10;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 2.25rem;
    }
</style>
