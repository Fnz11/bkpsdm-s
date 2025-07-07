<!-- Modal PDF -->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true"
    style="z-index: 1501;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('dashboard.pelatihan.user.cetak-pdf') }}" method="GET" target="_blank"
            id="form-cetak-pdf">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-semibold">Cetak PDF Data Pivot User</h5>
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
                    <div id="step-filter-pdf" class="step-content active" data-step="1">
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="filter-modal-search-pdf" class="form-label fw-semibold">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="filter-modal-search-pdf" class="form-control"
                                        placeholder="Cari nama/unit kerja/jabatan...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Unit Kerja</label>
                                <select name="unit_kerja" id="filter-modal-unit-kerja" class="form-select">
                                    <option value="">Semua Unit Kerja</option>
                                    @foreach ($unitkerjas as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis ASN</label>
                                <select name="jenis_asn" id="filter-modal-jenis-asn" class="form-select form-select-md">
                                    <option value="">Semua</option>
                                    @foreach ($jenisasns as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->jenis_asn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Rentang Tanggal Mulai</label>
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
                                                    <th>Nama</th>
                                                    <th>Unit Kerja</th>
                                                    <th>Jabatan</th>
                                                    <th>Golongan</th>
                                                    <th>Jenis ASN</th>
                                                    <th>Tgl Mulai</th>
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
                    <div id="step-konfirmasi-pdf" class="step-content d-none" data-step="3">
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
                                                    <td>Unit Kerja</td>
                                                    <td>: <span id="summary-unit-kerja">Semua</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis ASN</td>
                                                    <td>: <span id="summary-jenis-asn">Semua</span></td>
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
                                            <h6 class="fw-semibold text-primary">Pengaturan PDF</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="140">Ukuran Kertas</td>
                                                    <td>: <span id="summary-paper-size-pdf">A4</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Orientasi</td>
                                                    <td>: <span id="summary-orientation-pdf">Portrait</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Margin</td>
                                                    <td>: <span id="summary-margins-pdf">0.5in (atas), 0.5in (kanan),
                                                            0.5in (bawah), 0.5in (kiri)</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Header</td>
                                                    <td>: <span id="summary-header-pdf">Aktif</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Footer</td>
                                                    <td>: <span id="summary-footer-pdf">Aktif</span></td>
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
                    <input type="hidden" name="unit_kerja" id="input-unit-kerja">
                    <input type="hidden" name="jenis_asn" id="input-jenis-asn">
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
                        <button type="submit" class="btn btn-danger d-none" id="btn-submit-cetak-pdf" disabled>
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
        <form action="{{ route('dashboard.pelatihan.user.cetak-excel') }}" method="GET" target="_blank"
            id="form-excel">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-semibold">Export Excel Data Pivot User</h5>
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
                                        placeholder="Cari nama/unit kerja/jabatan...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="filter-modal-unit-kerja-excel" class="form-label fw-semibold">Unit
                                    Kerja</label>
                                <select name="unit_kerja" id="filter-modal-unit-kerja-excel" class="form-select">
                                    <option value="">Semua Unit Kerja</option>
                                    @foreach ($unitkerjas as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis ASN</label>
                                <select name="jenis_asn" id="filter-modal-jenis-asn-excel"
                                    class="form-select form-select-md">
                                    <option value="">Semua</option>
                                    @foreach ($jenisasns as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->jenis_asn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Rentang Tanggal Mulai</label>
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
                                                    <th>Nama</th>
                                                    <th>Unit Kerja</th>
                                                    <th>Jabatan</th>
                                                    <th>Golongan</th>
                                                    <th>Jenis ASN</th>
                                                    <th>Tgl Mulai</th>
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
                                                        value="no" id="col_no" checked>
                                                    <label class="form-check-label" for="col_no">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="nip" id="col_nip" checked>
                                                    <label class="form-check-label" for="col_nip">NIP</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="nama" id="col_nama" checked>
                                                    <label class="form-check-label" for="col_nama">Nama</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="unit_kerja" id="col_unit_kerja" checked>
                                                    <label class="form-check-label" for="col_unit_kerja">Unit
                                                        Kerja</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="sub_unit" id="col_sub_unit" checked>
                                                    <label class="form-check-label" for="col_sub_unit">Sub
                                                        Unit</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="kategori_jabatan" id="col_kategori_jabatan" checked>
                                                    <label class="form-check-label"
                                                        for="col_kategori_jabatan">Kategori Jabatan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="jabatan" id="col_jabatan" checked>
                                                    <label class="form-check-label" for="col_jabatan">Jabatan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="pangkat" id="col_pangkat" checked>
                                                    <label class="form-check-label" for="col_pangkat">Pangkat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="golongan" id="col_golongan" checked>
                                                    <label class="form-check-label"
                                                        for="col_golongan">Golongan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="jenis_asn" id="col_jenis_asn" checked>
                                                    <label class="form-check-label" for="col_jenis_asn">Jenis
                                                        ASN</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="tgl_mulai" id="col_tgl_mulai" checked>
                                                    <label class="form-check-label" for="col_tgl_mulai">Tgl
                                                        Mulai</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="columns[]"
                                                        value="tgl_akhir" id="col_tgl_akhir" checked>
                                                    <label class="form-check-label" for="col_tgl_akhir">Tgl
                                                        Akhir</label>
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
                                                    <td>Unit Kerja</td>
                                                    <td>: <span id="summary-unit-kerja-excel">Semua</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis ASN</td>
                                                    <td>: <span id="summary-jenis-asn-excel">Semua</span></td>
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
                                                    <td>: <span id="summary-header-excel">Ya</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Kolom Dipilih</td>
                                                    <td>: <span id="summary-columns">6 kolom</span></td>
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
                    <input type="hidden" name="unit_kerja" id="input-unit-kerja-excel">
                    <input type="hidden" name="jenis_asn" id="input-jenis-asn-excel">
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
