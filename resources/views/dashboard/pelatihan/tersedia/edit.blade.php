@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Pelatihan Tersedia')
@section('page-title', 'Edit Pelatihan Tersedia')

@section('additional-css')
    <style>
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
@endsection

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.tersedia') }}"><i
                    class="bi bi-calendar-check"></i> Pelatihan Tersedia</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-pencil-square"></i> Edit Pelatihan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning fw-bold text-white py-3">
            <i class="bi bi-pencil-square me-2"></i>Form Edit Pelatihan
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.tersedia.update', $pelatihan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-bookmark me-1"></i>Nama Pelatihan</label>
                        <select name="nama_pelatihan" class="form-select select2" id="nama" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($namapelatihans as $nama)
                                <option value="{{ $nama->nama_pelatihan }}"
                                    {{ $pelatihan->nama_pelatihan === $nama->nama_pelatihan ? 'selected' : '' }}>
                                    {{ $nama->nama_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-tag me-1"></i>Jenis Pelatihan</label>
                        <select name="jenispelatihan_id" class="form-select" id="jenis" required>
                            @foreach ($jenispelatihans as $jenis)
                                <option value="{{ $jenis->id }}"
                                    {{ $pelatihan->jenispelatihan_id == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->jenis_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-pc-display me-1"></i>Metode Pelatihan</label>
                        <select name="metodepelatihan_id" class="form-select" id="metode" required>
                            @foreach ($metodepelatihans as $metode)
                                <option value="{{ $metode->id }}"
                                    {{ $pelatihan->metodepelatihan_id == $metode->id ? 'selected' : '' }}>
                                    {{ $metode->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-check me-1"></i>Pelaksanaan
                            Pelatihan</label>
                        <select name="pelaksanaanpelatihan_id" class="form-select" id="pelaksanaan" required>
                            @foreach ($pelaksanaanpelatihans as $pelaksanaan)
                                <option value="{{ $pelaksanaan->id }}"
                                    {{ $pelatihan->pelaksanaanpelatihan_id == $pelaksanaan->id ? 'selected' : '' }}>
                                    {{ $pelaksanaan->pelaksanaan_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i>Penyelenggara</label>
                        <input type="text" name="penyelenggara_pelatihan" class="form-control" required
                            value="{{ old('penyelenggara_pelatihan', $pelatihan->penyelenggara_pelatihan) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i>Tempat</label>
                        <input type="text" name="tempat_pelatihan" class="form-control" required
                            value="{{ old('tempat_pelatihan', $pelatihan->tempat_pelatihan) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required
                            value="{{ old('tanggal_mulai', $pelatihan->tanggal_mulai) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar2-week me-1"></i>Tanggal
                            Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required
                            value="{{ old('tanggal_selesai', $pelatihan->tanggal_selesai) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-x me-1"></i>Tutup Pendaftaran</label>
                        <input type="date" name="tutup_pendaftaran" class="form-control" required
                            value="{{ old('tutup_pendaftaran', $pelatihan->tutup_pendaftaran) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-people me-1"></i>Kuota</label>
                        <input type="number" name="kuota" class="form-control" required
                            value="{{ old('kuota', $pelatihan->kuota) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-cash-stack me-1"></i>Biaya</label>
                        <input type="number" name="biaya" class="form-control" required
                            value="{{ old('biaya', $pelatihan->biaya) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold"><i class="bi bi-card-text me-1"></i>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-image me-1"></i>Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak mengubah gambar.</small>
                        @if ($pelatihan->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $pelatihan->gambar) }}"
                                    class="img-thumbnail" style="max-height: 180px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-toggle-on me-1"></i>Status</label>
                        <select name="status_pelatihan" class="form-select" required>
                            <option value="draft" {{ $pelatihan->status_pelatihan === 'draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="buka" {{ $pelatihan->status_pelatihan === 'buka' ? 'selected' : '' }}>Buka
                            </option>
                            <option value="tutup" {{ $pelatihan->status_pelatihan === 'tutup' ? 'selected' : '' }}>Tutup
                            </option>
                            <option value="selesai" {{ $pelatihan->status_pelatihan === 'selesai' ? 'selected' : '' }}>
                                Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="bi bi-arrow-left-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown lainnya
            $('#nama').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Nama Pelatihan',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
