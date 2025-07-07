@if ($pendaftarans->count() > 0)
    <div class="modern-table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-number">No</th>
                    <th class="col-date">Tanggal Daftar</th>
                    <th class="col-training">Detail Pelatihan</th>
                    <th class="col-category">Kategori</th>
                    <th class="col-file">Penawaran</th>
                    <th class="col-verification">Status Verifikasi</th>
                    <th class="col-participant">Status Peserta</th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftarans as $item)
                    @php
                        $pelatihan = $item->tersedia ?? $item->usulan;
                        $isUsulan = !is_null($item->usulan_id);
                    @endphp
                    <tr class="table-row" data-status="{{ $item->status_verifikasi }}">
                        <td class="col-number">
                            <span class="row-number">{{ $pendaftarans->firstItem() + $loop->index }}</span>
                        </td>
                        <td class="col-date">
                            <div class="date-info">
                                <i class="bi bi-calendar3 me-2 text-muted"></i>
                                <span
                                    class="date-text">{{ \Carbon\Carbon::parse($item->tanggal_pendaftaran)->translatedFormat('d M Y') }}</span>
                                <small
                                    class="date-day text-muted d-block">{{ \Carbon\Carbon::parse($item->tanggal_pendaftaran)->translatedFormat('l') }}</small>
                            </div>
                        </td>
                        <td class="col-training">
                            <div class="training-info">
                                <h6 class="training-title">
                                    {{ $item->tersedia?->nama_pelatihan ?? ($item->usulan?->nama_pelatihan ?? 'Tidak tersedia') }}
                                </h6>
                                {{-- <div class="training-meta">
                                    @if ($item->usulan_id)
                                        <span class="meta-badge badge-usulan">
                                            <i class="bi bi-person-plus-fill me-1"></i>
                                            Usulan Mandiri
                                        </span>
                                    @elseif ($item->tersedia_id)
                                        <span class="meta-badge badge-tersedia">
                                            <i class="bi bi-calendar-check-fill me-1"></i>
                                            Pelatihan Tersedia
                                        </span>
                                    @else
                                        <span class="meta-badge badge-unknown">
                                            <i class="bi bi-question-circle-fill me-1"></i>
                                            Tidak diketahui
                                        </span>
                                    @endif
                                </div> --}}
                            </div>
                        </td>
                        <td class="col-category">
                            @if ($item->usulan_id)
                                <span class="category-badge category-usulan">
                                    <i class="bi bi-mortarboard-fill me-1"></i>
                                    Usulan
                                </span>
                            @elseif ($item->tersedia_id)
                                <span class="category-badge category-tersedia">
                                    <i class="bi bi-calendar-event-fill me-1"></i>
                                    Tersedia
                                </span>
                            @else
                                <span class="category-badge category-unknown">
                                    <i class="bi bi-question-circle-fill me-1"></i>
                                    N/A
                                </span>
                            @endif
                        </td>
                        <td class="col-file">
                            @if ($isUsulan && $pelatihan?->file_penawaran)
                                <a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}" target="_blank"
                                    class="btn btn-elegant btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                    title="Lihat file penawaran">
                                    <i class="bi bi-file-earmark-text-fill me-1"></i>
                                    <span>Lihat File</span>
                                </a>
                            @else
                                <span class="text-muted">
                                    <i class="bi bi-dash-circle me-1"></i>
                                    Tidak ada
                                </span>
                            @endif
                        </td>
                        <td class="col-verification">
                            @php
                                $statusClass = match ($item->status_verifikasi) {
                                    'tersimpan' => 'status-saved',
                                    'terkirim' => 'status-sent',
                                    'diterima' => 'status-accepted',
                                    'tercetak' => 'status-processed',
                                    default => 'status-rejected',
                                };
                                $statusIcon = match ($item->status_verifikasi) {
                                    'tersimpan' => 'bi-save-fill',
                                    'terkirim' => 'bi-send-fill',
                                    'diterima' => 'bi-check-circle-fill',
                                    'tercetak' => 'bi-printer-fill',
                                    default => 'bi-x-circle-fill',
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="bi {{ $statusIcon }} me-1"></i>
                                {{ ucfirst($item->status_verifikasi) }}
                            </span>
                        </td>
                        <td class="col-participant">
                            @php
                                $participantClass = match ($item->status_peserta) {
                                    'calon_peserta' => 'participant-candidate',
                                    'peserta' => 'participant-active',
                                    'alumni' => 'participant-alumni',
                                    default => 'participant-unknown',
                                };
                                $participantIcon = match ($item->status_peserta) {
                                    'calon_peserta' => 'bi-person-plus-fill',
                                    'peserta' => 'bi-person-check-fill',
                                    'alumni' => 'bi-mortarboard-fill',
                                    default => 'bi-person-dash-fill',
                                };
                            @endphp
                            <span class="participant-badge {{ $participantClass }}">
                                <i class="bi {{ $participantIcon }} me-1"></i>
                                {{ ucwords(str_replace('_', ' ', $item->status_peserta)) }}
                            </span>
                        </td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <a href="{{ route('pelatihan.pendaftaran.show', $item->id) }}"
                                    class="btn btn-elegant btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                    title="Lihat detail pendaftaran">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h6 class="empty-title">Belum Ada Pendaftaran</h6>
        <p class="empty-text">Anda belum memiliki pendaftaran pelatihan. Mulai dengan mendaftar pelatihan yang tersedia
            atau buat usulan pelatihan baru.</p>
        <div class="empty-actions">
            <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-outline-secondary">
                <i class="bi bi-mortarboard me-2"></i>
                Lihat Usulan Pelatihan
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
    .col-number {
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

    .col-date {
        min-width: 120px;
    }

    .date-info {
        display: flex;
        flex-direction: column;
    }

    .date-text {
        font-weight: 600;
        color: var(--text-primary);
    }

    .date-day {
        font-size: 0.75rem;
        margin-top: 0.125rem;
    }

    .col-training {
        min-width: 250px;
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

    .badge-unknown {
        background: rgba(148, 163, 184, 0.15);
        color: var(--text-muted);
    }

    /* Category Badges */
    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 1rem;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .category-usulan {
        background: var(--primary-soft);
        color: white;
    }

    .category-tersedia {
        background: var(--success-soft);
        color: white;
    }

    .category-unknown {
        background: var(--secondary-soft);
        color: white;
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

    .status-saved {
        background: rgba(148, 163, 184, 0.15);
        color: #64748b;
    }

    .status-sent {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .status-accepted {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .status-processed {
        background: rgba(251, 191, 36, 0.15);
        color: #d97706;
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    /* Participant Badges */
    .participant-badge {
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

    .participant-candidate {
        background: rgba(251, 191, 36, 0.15);
        color: #d97706;
    }

    .participant-active {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .participant-alumni {
        background: rgba(168, 85, 247, 0.15);
        color: #9333ea;
    }

    .participant-unknown {
        background: rgba(148, 163, 184, 0.15);
        color: #64748b;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

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
        .category-badge,
        .status-badge,
        .participant-badge {
            font-size: 0.6875rem;
            padding: 0.25rem 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
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
    }
</style>
