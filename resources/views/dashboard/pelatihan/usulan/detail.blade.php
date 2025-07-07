@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Usulan Pelatihan')
@section('page-title', 'Detail Usulan Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.usulan') }}"><i class="bi bi-lightbulb"></i> Usulan
                Pelatihan</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-info-circle"></i> Detail Usulan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm ">
        <div class="card-header bg-light fw-bold">
            <i class="bi bi-info-circle me-2"></i>Informasi Detail Usulan Pelatihan
        </div>

        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">{{ $pelatihan->nama_pelatihan }}</h4>
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                    <i class="bi bi-arrow-left-circle me-1"></i>Kembali
                </button>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span><i class="bi bi-person-vcard me-1"></i><strong>Pengusul</strong></span>
                            <p class="text-end mt-2 mb-0">
                                {{ $pelatihan->user->refPegawai->name }}({{ $pelatihan->nip_pengusul }})</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-tag me-1"></i><strong>Jenis Pelatihan</strong></span>
                            <span>{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-pc-display me-1"></i><strong>Metode</strong></span>
                            <span>{{ $pelatihan->metodepelatihan->metode_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-check me-1"></i><strong>Pelaksanaan</strong></span>
                            <span>{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-building me-1"></i><strong>Penyelenggara</strong></span>
                            <span>{{ $pelatihan->penyelenggara_pelatihan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-geo-alt me-1"></i><strong>Tempat</strong></span>
                            <span>{{ $pelatihan->tempat_pelatihan }}</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-range me-1"></i><strong>Periode</strong></span>
                            <span>
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}
                                -
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d F Y') }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-cash-stack me-1"></i><strong>Estimasi Biaya</strong></span>
                            <span>Rp{{ number_format($pelatihan->estimasi_biaya, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-cash-coin me-1"></i><strong>Realisasi Biaya</strong></span>
                            <span>
                                @if ($pelatihan->realisasi_biaya)
                                    Rp{{ number_format($pelatihan->realisasi_biaya, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            <span><i class="bi bi-card-text me-1"></i><strong>Keterangan</strong></span>
                            <p class="text-muted mt-2 mb-0">{{ $pelatihan->keterangan }}</p>
                        </li>
                        <li class="list-group-item">
                            <span><i class="bi bi-file-earmark-text me-1"></i><strong>File Penawaran</strong></span>
                            <div class="mt-2">
                                @if ($pelatihan->file_penawaran)
                                    <a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-download me-1"></i>Unduh File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-plus me-1"></i><strong>Diusulkan</strong></span>
                            <span>{{ $pelatihan->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-check me-1"></i><strong>Terakhir Diubah</strong></span>
                            <span>{{ $pelatihan->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if ($pelatihan->pendaftaran->status_verifikasi === 'terkirim')
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="bi bi-check-circle me-1"></i>Setujui
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-1"></i>Tolak
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dashboard.pelatihan.usulan.update', $pelatihan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="approveModalLabel">Setujui Usulan Pelatihan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="realisasi_biaya" class="form-label">Realisasi Biaya</label>
                            <input type="number" class="form-control" id="realisasi_biaya" name="realisasi_biaya"
                                value="{{ $pelatihan->estimasi_biaya }}" step="1000" required>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                        </div>
                        <input type="text" name="status_verifikasi" value="diterima" hidden>
                        <p>Anda yakin ingin menyetujui usulan pelatihan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dashboard.pelatihan.usulan.update', $pelatihan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="rejectModalLabel">Tolak Usulan Pelatihan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3" required></textarea>
                        </div>
                        <input type="text" name="status_verifikasi" value="ditolak" hidden>
                        <p>Anda yakin ingin menolak usulan pelatihan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('alert'))
        <script>
            showAlertModal("{{ session('alert') }}", "{{ session('title') }}");
        </script>
    @endif
@endsection
