@if($laporans->count() > 0)
    <div class="modern-table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-training">Detail Pelatihan</th>
                    <th class="col-judul">Judul Laporan</th>
                    <th class="col-latar">Latar Belakang</th>
                    <th class="col-hasil">Status</th>
                    <th class="col-biaya">Biaya</th>
                    <th class="col-laporan">Laporan</th>
                    <th class="col-sertifikat">Sertifikat</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporans as $index => $laporan)
                    <tr class="table-row" data-status="{{ strtolower($laporan->hasil_pelatihan) }}">
                        <td class="col-no">
                            <span class="row-number">{{ $loop->iteration }}</span>
                        </td>
                        <td class="col-training">
                            <div class="training-info">
                                <h6 class="training-title">
                                    {{ $laporan->pendaftaran?->tersedia?->nama_pelatihan ?? ($laporan->pendaftaran?->usulan?->nama_pelatihan ?? 'Tidak tersedia') }}
                                </h6>
                                <div class="training-meta">
                                    @php
                                        $isUsulan = !is_null($laporan->pendaftaran?->usulan_id);
                                    @endphp
                                    @if ($isUsulan)
                                        <span class="meta-badge badge-usulan">
                                            <i class="bi bi-person-plus-fill me-1"></i>
                                            Usulan Mandiri
                                        </span>
                                    @else
                                        <span class="meta-badge badge-tersedia">
                                            <i class="bi bi-calendar-check-fill me-1"></i>
                                            Pelatihan Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="col-judul">
                            <div class="report-title">
                                <i class="bi bi-file-text me-2 text-muted"></i>
                                <span>{{ $laporan->judul_laporan }}</span>
                            </div>
                        </td>
                        <td class="col-latar">
                            <div class="background-text">
                                <span class="text-content" data-bs-toggle="tooltip" title="{{ $laporan->latar_belakang }}">
                                    {{ Str::limit($laporan->latar_belakang, 50) }}
                                </span>
                            </div>
                        </td>
                        <td class="col-hasil">
                            @php
                                $statusClass = match(strtolower($laporan->hasil_pelatihan)) {
                                    'revisi' => 'status-revision',
                                    'lulus' => 'status-passed',
                                    'tidak lulus' => 'status-failed',
                                    'draft' => 'status-draft',
                                    'proses' => 'status-process',
                                    default => 'status-pending'
                                };
                                $statusIcon = match(strtolower($laporan->hasil_pelatihan)) {
                                    'revisi' => 'bi-arrow-clockwise',
                                    'lulus' => 'bi-check-circle-fill',
                                    'tidak lulus' => 'bi-x-circle-fill',
                                    'draft' => 'bi-file-earmark-text',
                                    'proses' => 'bi-hourglass-split',
                                    default => 'bi-clock-fill'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="bi {{ $statusIcon }} me-1"></i>
                                {{ ucfirst($laporan->hasil_pelatihan) }}
                            </span>
                        </td>
                        <td class="col-biaya">
                            <div class="cost-display">
                                <i class="bi bi-currency-dollar me-1 text-muted"></i>
                                <span class="cost-value">Rp {{ number_format($laporan->total_biaya, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="col-laporan">
                            @if($laporan->laporan)
                                <a href="{{ asset('storage/laporan/' . $laporan->laporan) }}" 
                                   target="_blank" 
                                   class="btn btn-elegant btn-outline-primary btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="Lihat laporan">
                                    <i class="bi bi-file-earmark-text-fill me-1"></i>
                                    <span>Lihat</span>
                                </a>
                            @else
                                <span class="file-empty">
                                    <i class="bi bi-dash-circle me-1"></i>
                                    Belum ada
                                </span>
                            @endif
                        </td>
                        <td class="col-sertifikat">
                            @if($laporan->sertifikat)
                                <a href="{{ asset('storage/sertifikat/' . $laporan->sertifikat) }}" 
                                   target="_blank" 
                                   class="btn btn-elegant btn-outline-success btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="Lihat sertifikat">
                                    <i class="bi bi-award-fill me-1"></i>
                                    <span>Lihat</span>
                                </a>
                            @else
                                <span class="file-empty">
                                    <i class="bi bi-dash-circle me-1"></i>
                                    Belum ada
                                </span>
                            @endif
                        </td>
                        <td class="col-aksi">
                            <div class="action-buttons">
                                @php
                                    // Ambil data deadline langsung dari relasi
                                    $deadline = $laporan->pendaftaran->tenggatUpload ?? null;
                                    
                                    // Cek apakah masih bisa upload
                                    $canUpload = true;
                                    $deadlineText = '';
                                    
                                    if ($deadline) {
                                        $canUpload = now() < $deadline->tanggal_deadline;
                                        $formattedDeadline = \Carbon\Carbon::parse($deadline->tanggal_deadline)->format('d F Y H:i');
                                        $deadlineText = "Tenggat upload: {$formattedDeadline}";
                                    }
                                @endphp
                                
                                {{-- Tombol Edit --}}
                                @if(!in_array(strtolower($laporan->hasil_pelatihan), ['lulus', 'tidak lulus','proses']) && $canUpload)
                                    <button type="button" 
                                            class="btn btn-elegant btn-outline-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#updateModal{{ $laporan->id }}" 
                                            title="Edit laporan">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                @elseif(!$canUpload && $deadline)
                                    <span class="btn btn-elegant btn-outline-danger btn-sm disabled" 
                                          data-bs-toggle="tooltip" 
                                          title="Tenggat upload telah berakhir pada {{ $formattedDeadline }}">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Expired
                                    </span>
                                @endif

                                {{-- Tombol Detail --}}
                                <a href="{{ route('pelatihan.laporan-show', $laporan->id) }}" 
                                   class="btn btn-elegant btn-outline-primary btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                
                                {{-- Info Deadline --}}
                                @if($deadline && $canUpload)
                                    <div class="deadline-info">
                                        <i class="bi bi-clock me-1"></i>
                                        <small>{{ $deadlineText }}</small>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    @if(strtolower($laporan->hasil_pelatihan) == 'revisi' || !$laporan->laporan)
                        <div class="modal fade modal-modern" id="updateModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $laporan->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header modal-header-modern 
                                        @if(strtolower($laporan->hasil_pelatihan) == 'revisi') header-warning
                                        @else header-primary @endif">
                                        <h5 class="modal-title" id="updateModalLabel{{ $laporan->id }}">
                                            <i class="bi bi-pencil-square me-2"></i>
                                            @if(strtolower($laporan->hasil_pelatihan) == 'revisi') 
                                                Perbaikan Laporan
                                            @elseif(strtolower($laporan->hasil_pelatihan) == 'draft') 
                                                Perbarui Laporan
                                            @else 
                                                Lengkapi Laporan 
                                            @endif
                                        </h5>
                                        <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <form action="{{ route('pelatihan.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="form-modern">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body modal-body-modern">
                                            <!-- Status Alert -->
                                            @if(strtolower($laporan->hasil_pelatihan) == 'revisi')
                                                <div class="alert alert-modern alert-warning">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    <strong>Revisi Diperlukan:</strong> Laporan Anda memerlukan perbaikan. Silakan perbarui sesuai catatan.
                                                </div>
                                            @elseif(strtolower($laporan->hasil_pelatihan) == 'draft')
                                                <div class="alert alert-modern alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <strong>Draft Laporan:</strong> Anda masih dapat memperbarui laporan sebelum tenggat.
                                                </div>
                                            @else
                                                <div class="alert alert-modern alert-primary">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <strong>Lengkapi Laporan:</strong> Silakan lengkapi data laporan dan unggah berkas yang diperlukan.
                                                </div>
                                            @endif

                                            <!-- Form Fields -->
                                            <div class="form-section">
                                                <div class="form-group-modern" style="width: 85.5%">
                                                    <label for="judul_laporan{{ $laporan->id }}" class="form-label-modern">
                                                        <i class="bi bi-file-text me-1"></i>Judul Laporan
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control-modern" 
                                                           id="judul_laporan{{ $laporan->id }}" 
                                                           name="judul_laporan" 
                                                           value="{{ $laporan->judul_laporan }}" 
                                                           required>
                                                </div>

                                                <div class="form-group-modern" style="width: 85.5%">
                                                    <label for="latar_belakang{{ $laporan->id }}" class="form-label-modern">
                                                        <i class="bi bi-file-text me-1"></i>Latar Belakang
                                                    </label>
                                                    <textarea class="form-control-modern" 
                                                              id="latar_belakang{{ $laporan->id }}" 
                                                              name="latar_belakang" 
                                                              rows="3" 
                                                              required>{{ $laporan->latar_belakang }}</textarea>
                                                </div>

                                                <div class="form-group-modern" style="width: 85.5%">
                                                    <label for="total_biaya{{ $laporan->id }}" class="form-label-modern">
                                                        <i class="bi bi-currency-dollar me-1"></i>Total Biaya
                                                    </label>
                                                    <input type="number" 
                                                           class="form-control-modern" 
                                                           id="total_biaya{{ $laporan->id }}" 
                                                           name="total_biaya" 
                                                           value="{{ $laporan->total_biaya }}" 
                                                           min="0" 
                                                           required>
                                                </div>

                                                <div class="form-row">
                                                    <!-- Upload Laporan -->
                                                    <div class="form-group-modern">
                                                        <label for="laporan{{ $laporan->id }}" class="form-label-modern">
                                                            <i class="bi bi-file-earmark-text me-1"></i>File Laporan
                                                        </label>
                                                        <input type="file" 
                                                               class="form-control-modern file-input" 
                                                               id="laporan{{ $laporan->id }}" 
                                                               name="laporan" 
                                                               accept=".pdf,.doc,.docx" 
                                                               {{ !$laporan->laporan ? 'required' : '' }}>
                                                        <div class="file-help">
                                                            <small class="text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
                                                            @if($laporan->laporan)
                                                                <div class="current-file">
                                                                    <i class="bi bi-check-circle text-success me-1"></i>
                                                                    <small>File saat ini: {{ $laporan->laporan }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Upload Sertifikat -->
                                                    <div class="form-group-modern" style="width: 69.5%">
                                                        <label for="sertifikat{{ $laporan->id }}" class="form-label-modern">
                                                            <i class="bi bi-award me-1"></i>File Sertifikat
                                                        </label>
                                                        <input type="file" 
                                                               class="form-control-modern file-input" 
                                                               id="sertifikat{{ $laporan->id }}" 
                                                               name="sertifikat" 
                                                               accept=".pdf,.jpg,.jpeg,.png" 
                                                               {{ !$laporan->sertifikat ? 'required' : '' }}>
                                                        <div class="file-help">
                                                            <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                                            @if($laporan->sertifikat)
                                                                <div class="current-file">
                                                                    <i class="bi bi-check-circle text-success me-1"></i>
                                                                    <small>File saat ini: {{ $laporan->sertifikat }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer modal-footer-modern">
                                            <button type="button" class="btn btn-elegant btn-outline-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-elegant 
                                                @if(strtolower($laporan->hasil_pelatihan) == 'revisi') btn-warning
                                                @elseif(strtolower($laporan->hasil_pelatihan) == 'draft') btn-info
                                                @else btn-primary @endif">
                                                <i class="bi bi-check-circle me-1"></i>
                                                @if(strtolower($laporan->hasil_pelatihan) == 'revisi') Perbaiki
                                                @elseif(strtolower($laporan->hasil_pelatihan) == 'draft') Perbarui
                                                @else Simpan @endif
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h6 class="empty-title">Belum Ada Laporan</h6>
        <p class="empty-text">Anda belum memiliki laporan pelatihan. Laporan akan muncul setelah Anda menyelesaikan pelatihan.</p>
        <div class="empty-actions">
            <a href="{{ route('pelatihan.pendaftaran') }}" class="btn btn-elegant btn-outline-secondary">
                <i class="bi bi-clipboard-check me-2"></i>
                Lihat Pendaftaran
            </a>
        </div>
    </div>
@endif

<style>
    /* Modern Table Styles */
    .modern-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow-sm);
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        background: var(--bg-primary);
    }

    .modern-table th {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, #f1f5f9 100%);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modern-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .table-row {
        transition: var(--transition);
    }

    .table-row:nth-child(even) {
        background: rgba(248, 250, 252, 0.5);
    }

    .table-row:hover {
        background: rgba(139, 157, 195, 0.05);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    /* Column Specific Styles */
    .col-no {
        width: 60px;
        text-align: center;
    }

    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        background: var(--bg-secondary);
        border-radius: 50%;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.75rem;
    }

    .col-training {
        min-width: 200px;
    }

    .training-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .training-title {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.4;
        font-size: 0.875rem;
    }

    .training-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }

    .meta-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-usulan {
        background: rgba(139, 157, 195, 0.15);
        color: var(--primary-hover);
    }

    .badge-tersedia {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    /* Report Title */
    .report-title {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        line-height: 1.4;
    }

    /* Background Text */
    .background-text {
        max-width: 200px;
    }

    .text-content {
        cursor: help;
        line-height: 1.4;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 1rem;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-revision {
        background: rgba(251, 191, 36, 0.15);
        color: #d97706;
    }

    .status-passed {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .status-failed {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .status-draft {
        background: rgba(148, 163, 184, 0.15);
        color: #64748b;
    }

    .status-process {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .status-pending {
        background: rgba(168, 85, 247, 0.15);
        color: #9333ea;
    }

    /* Cost Display */
    .cost-display {
        display: flex;
        align-items: center;
        font-family: 'Familjen Grotesk', sans-serif;
        font-weight: 600;
    }

    .cost-value {
        color: var(--text-primary);
    }

    /* File Empty State */
    .file-empty {
        display: flex;
        align-items: center;
        color: var(--text-muted);
        font-style: italic;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: center;
    }

    .deadline-info {
        display: flex;
        align-items: center;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-align: center;
        margin-top: 0.5rem;
    }

    /* Buttons */
    .btn-elegant {
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius-sm);
        border: 2px solid transparent;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-elegant.btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.8125rem;
    }

    .btn-elegant.btn-outline-primary {
        color: var(--primary-soft);
        border-color: var(--primary-soft);
        background: var(--bg-primary);
    }

    .btn-elegant.btn-outline-primary:hover {
        background: var(--primary-soft);
        border-color: var(--primary-soft);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-elegant.btn-outline-success {
        color: var(--success-soft);
        border-color: var(--success-soft);
        background: var(--bg-primary);
    }

    .btn-elegant.btn-outline-success:hover {
        background: var(--success-soft);
        border-color: var(--success-soft);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-elegant.btn-outline-warning {
        color: var(--warning-soft);
        border-color: var(--warning-soft);
        background: var(--bg-primary);
    }

    .btn-elegant.btn-outline-warning:hover {
        background: var(--warning-soft);
        border-color: var(--warning-soft);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-elegant.btn-outline-danger {
        color: var(--danger-soft);
        border-color: var(--danger-soft);
        background: var(--bg-primary);
    }

    .btn-elegant.btn-outline-secondary {
        color: var(--text-secondary);
        border-color: var(--border-color);
        background: var(--bg-primary);
    }

    .btn-elegant.btn-outline-secondary:hover {
        background: var(--bg-secondary);
        border-color: var(--text-secondary);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-elegant.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-elegant.disabled:hover {
        transform: none;
        box-shadow: none;
    }

    /* Modal Styles */
    .modal-modern .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
    }

    .modal-header-modern {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .modal-header-modern.header-warning {
        background: linear-gradient(135deg, var(--warning-soft) 0%, #f59e0b 100%);
        color: white;
    }

    .modal-header-modern.header-primary {
        background: var(--gradient-primary);
        color: white;
    }

    .modal-header-modern .modal-title {
        font-weight: 600;
        margin: 0;
    }

    .btn-close-modern {
        filter: brightness(0) invert(1);
    }

    .modal-body-modern {
        padding: 2rem;
    }

    .modal-footer-modern {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-secondary);
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    /* Form Styles */
    .form-section {
        display: grid;
        gap: 1.5rem;
    }

    .form-group-modern {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        margin: 0;
    }

    .form-control-modern {
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        padding: 0.75rem;
        transition: var(--transition);
        font-size: 1rem;
    }

    .form-control-modern:focus {
        border-color: var(--primary-soft);
        box-shadow: 0 0 0 3px rgba(139, 157, 195, 0.1);
        outline: none;
    }

    .file-input {
        padding: 0.5rem;
    }

    .file-help {
        margin-top: 0.5rem;
    }

    .current-file {
        margin-top: 0.25rem;
        padding: 0.375rem 0.75rem;
        background: rgba(34, 197, 94, 0.1);
        border-radius: var(--border-radius-sm);
    }

    /* Alert Styles */
    .alert-modern {
        padding: 1rem;
        border-radius: var(--border-radius-sm);
        border: 1px solid;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .alert-warning {
        background: rgba(251, 191, 36, 0.1);
        border-color: var(--warning-soft);
        color: #92400e;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border-color: var(--info-soft);
        color: #1e40af;
    }

    .alert-primary {
        background: rgba(139, 157, 195, 0.1);
        border-color: var(--primary-soft);
        color: var(--primary-hover);
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: var(--text-muted);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        font-size: 1rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        max-width: 400px;
        line-height: 1.6;
    }

    .empty-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-table th,
        .modern-table td {
            padding: 0.75rem 0.5rem;
        }

        .training-title {
            font-size: 0.8125rem;
        }

        .meta-badge,
        .status-badge {
            font-size: 0.6875rem;
            padding: 0.25rem 0.5rem;
        }

        .action-buttons {
            gap: 0.375rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .deadline-info {
            font-size: 0.6875rem;
        }
    }

    /* CSS Variables (should match global palette) */
    :root {
        --primary-soft: #8b9dc3;
        --primary-hover: #7289b0;
        --success-soft: #a3d977;
        --warning-soft: #f5d76e;
        --danger-soft: #f87171;
        --info-soft: #7dd3fc;
        --light-soft: #f8fafc;
        --secondary-soft: #94a3b8;
        --dark-soft: #334155;
        --text-primary: #1e293b;
        --text-secondary: #475569;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --shadow-sm: 0 2px 4px rgba(148, 163, 184, 0.1);
        --shadow-md: 0 4px 12px rgba(148, 163, 184, 0.15);
        --border-radius: 12px;
        --border-radius-sm: 8px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --gradient-primary: linear-gradient(135deg, #8b9dc3 0%, #7289b0 100%);
    }
</style>