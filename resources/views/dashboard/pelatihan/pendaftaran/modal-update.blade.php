<!-- Modal Update Bulk Status -->
<div class="modal fade" id="modalUpdateBulk" tabindex="-1" aria-labelledby="modalUpdateBulkLabel" aria-hidden="true"
    style="z-index: 1501;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Update Status Pendaftaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.pelatihan.pendaftaran.update-bulk') }}" method="POST"
                id="form-update-bulk">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i> Pilih pendaftaran dan setidaknya satu status untuk
                        diperbarui.
                    </div>

                    <div class="form-group mb-3">
                        <label for="search-box-bulk" class="form-label fw-semibold">Cari Pendaftaran</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" id="search-box-bulk"
                                placeholder="Cari berdasarkan kode, nama, atau pelatihan..." class="form-control">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-check">
                                <input type="checkbox" id="select-all-bulk" class="form-check-input">
                                <label for="select-all-bulk" class="form-check-label">Pilih Semua</label>
                            </div>
                            <span id="selected-count-bulk" class="badge bg-primary">
                                0 pendaftaran dipilih
                            </span>
                        </div>

                        <div id="checkbox-list-bulk" class="border p-3 rounded overflow-auto"
                            style="max-height: 400px;">
                            @forelse ($pendaftarans2 as $item)
                                @php
                                    $pelatihan = $item->tersedia ?? $item->usulan;
                                    $namaPelatihan = $pelatihan->nama_pelatihan ?? '-';
                                    $namaUser = $item->user->refPegawai->name ?? '-';
                                    $unitKerja =
                                        $item->user->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-';
                                    $kode = $item->kode_pendaftaran ?? '-';
                                    $currentStatus = $item->status_verifikasi;
                                @endphp
                                <div class="checkbox-item px-2 py-2 rounded mb-1 {{ $currentStatus === 'ditolak' ? 'bg-light-danger' : ($currentStatus === 'diterima' ? 'bg-light-success' : '') }}"
                                    data-nama="{{ strtolower($kode) }} {{ strtolower($namaUser) }} {{ strtolower($namaPelatihan) }} {{ strtolower($unitKerja) }}">
                                    <label class="d-flex align-items-center m-0">
                                        <input type="checkbox" class="form-check-input me-2" name="pendaftaran_ids[]"
                                            value="{{ $item->id }}">
                                        <span class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $kode }} - {{ $namaUser }} - {{ $unitKerja }}</span>
                                            <span class="text-muted small">{{ $namaPelatihan }}</span>
                                            <span class="mt-1">
                                                <span
                                                    class="badge {{ $item->tersedia ? 'bg-warning' : 'bg-success' }} me-1">
                                                    {{ $item->tersedia ? 'Tersedia' : 'Usulan' }}
                                                </span>
                                                <span class="badge bg-secondary">
                                                    Status: {{ Str::title(str_replace('_', ' ', $currentStatus)) }}
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    Tidak ada data pendaftaran
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-select">
                                <option value="">-- Tidak diubah --</option>
                                <option value="tersimpan">Tersimpan</option>
                                <option value="tercetak">Tercetak</option>
                                <option value="terkirim">Terkirim</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Peserta</label>
                            <select name="status_peserta" class="form-select">
                                <option value="">-- Tidak diubah --</option>
                                <option value="calon_peserta">Calon Peserta</option>
                                <option value="peserta">Peserta</option>
                                <option value="alumni">Alumni</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-bulk" disabled>
                        <i class="bi bi-check-circle me-1"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #checkbox-list-bulk label {
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
</style>
