<!-- Modal Update Bulk Laporan -->
<div class="modal fade" id="modalUpdateBulkLaporan" tabindex="-1" aria-labelledby="modalUpdateBulkLaporanLabel" aria-hidden="true" style="z-index: 1501;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Update Status Laporan Pelatihan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.pelatihan.laporan.update-bulk') }}" method="POST" id="form-update-bulk-laporan">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i> Pilih laporan dan setidaknya satu status untuk diperbarui.
                    </div>

                    <div class="form-group mb-3">
                        <label for="search-box-bulk-laporan" class="form-label fw-semibold">Cari Laporan</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" id="search-box-bulk-laporan" 
                                   placeholder="Cari berdasarkan judul, nama peserta, atau pelatihan..." 
                                   class="form-control">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-check">
                                <input type="checkbox" id="select-all-bulk-laporan" class="form-check-input">
                                <label for="select-all-bulk-laporan" class="form-check-label">Pilih Semua</label>
                            </div>
                            <span id="selected-count-bulk-laporan" class="badge bg-primary">
                                0 laporan dipilih
                            </span>
                        </div>

                        <div id="checkbox-list-bulk-laporan" class="border p-3 rounded overflow-auto" style="max-height: 400px;">
                            @forelse ($laporans as $laporan)
                                @php
                                    $pendaftaran = $laporan->pendaftaran;
                                    $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
                                    $namaPelatihan = $pelatihan->nama_pelatihan ?? '-';
                                    $namaUser = $pendaftaran->user->refPegawai->name ?? '-';
                                    $unitKerja = $pendaftaran->user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-';
                                    $currentStatus = $laporan->hasil_pelatihan;
                                @endphp
                                <div class="checkbox-item px-2 py-2 rounded mb-1 
                                    {{ $currentStatus === 'tidak_lulus' ? 'bg-light-danger' : ($currentStatus === 'lulus' ? 'bg-light-success' : 'bg-light-warning') }}"
                                    data-nama="{{ strtolower($laporan->judul_laporan) }} {{ strtolower($namaUser) }} {{ strtolower($namaPelatihan) }} {{ strtolower($unitKerja) }}">
                                    <label class="d-flex align-items-center m-0">
                                        <input type="checkbox" class="form-check-input me-2" name="laporan_ids[]" value="{{ $laporan->id }}">
                                        <span class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $laporan->judul_laporan }} - {{ $namaUser }}</span>
                                            <span class="text-muted small">{{ $namaPelatihan }}</span>
                                            <span class="mt-1">
                                                <span class="badge 
                                                    @if($currentStatus === 'lulus') bg-success
                                                    @elseif($currentStatus === 'tidak_lulus') bg-danger
                                                    @elseif($currentStatus === 'revisi') bg-warning
                                                    @else bg-secondary @endif">
                                                    Hasil: {{ ucfirst(str_replace('_', ' ', $currentStatus)) }}
                                                </span>
                                                <span class="badge bg-primary ms-1">
                                                    Biaya: Rp{{ number_format($laporan->total_biaya, 0, ',', '.') }}
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    Tidak ada data laporan
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Hasil Pelatihan</label>
                            <select name="hasil_pelatihan" class="form-select">
                                <option value="">-- Tidak diubah --</option>
                                <option value="draft">Draft</option>
                                <option value="proses">Proses</option>
                                <option value="revisi">Revisi</option>
                                <option value="lulus">Lulus</option>
                                <option value="tidak_lulus">Tidak Lulus</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-bulk-laporan" disabled>
                        <i class="bi bi-check-circle me-1"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #checkbox-list-bulk-laporan label {
        cursor: pointer;
        width: 100%;
    }

    .checkbox-item {
        transition: all 0.2s;
    }

    .checkbox-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .checkbox-item input[type="checkbox"] {
        margin-top: 0;
    }

    .bg-light-success {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-light-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
</style>