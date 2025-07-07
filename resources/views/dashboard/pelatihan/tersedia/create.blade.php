@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Tambah Pelatihan')
@section('page-title', 'Tambah Pelatihan')

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
        <li class="breadcrumb-item active"><i class="bi bi-plus-circle"></i> Tambah Pelatihan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold"><i class="bi bi-plus-circle me-2"></i>Form Tambah Pelatihan</div>
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.tersedia.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-bookmark me-1"></i>Nama Pelatihan</label>
                        <select class="form-select select2" id="nama" name="nama_pelatihan" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($namapelatihans as $nama)
                                <option value="{{ $nama->nama_pelatihan }}">{{ $nama->nama_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-tags me-1"></i>Jenis Pelatihan</label>
                        <select class="form-select" name="jenispelatihan_id" required>
                            <option value="">-- Pilih Jenis Pelatihan --</option>
                            @foreach ($jenispelatihans as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-pc-display me-1"></i>Metode Pelatihan</label>
                        <select class="form-select" name="metodepelatihan_id" required>
                            <option value="">-- Pilih Metode Pelatihan --</option>
                            @foreach ($metodepelatihans as $metode)
                                <option value="{{ $metode->id }}">{{ $metode->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-check me-1"></i>Pelaksanaan
                            Pelatihan</label>
                        <select class="form-select" name="pelaksanaanpelatihan_id" required>
                            <option value="">-- Pilih Pelaksanaan Pelatihan --</option>
                            @foreach ($pelaksanaanpelatihans as $pelaksanaan)
                                <option value="{{ $pelaksanaan->id }}">{{ $pelaksanaan->pelaksanaan_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i>Penyelenggara</label>
                        <input type="text" class="form-control" name="penyelenggara_pelatihan" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i>Tempat
                            Pelatihan</label>
                        <input type="text" class="form-control" name="tempat_pelatihan">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar2-week me-1"></i>Tanggal
                            Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-x me-1"></i>Tutup Pendaftaran</label>
                        <input type="date" name="tutup_pendaftaran" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-people me-1"></i>Kuota</label>
                        <input type="number" name="kuota" class="form-control" min="1">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-cash-stack me-1"></i>Biaya</label>
                        <input type="number" name="biaya" class="form-control" min="0" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold"><i
                                class="bi bi-file-earmark-text me-1"></i>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-image me-1"></i>Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-toggle-on me-1"></i>Status</label>
                        <select name="status_pelatihan" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="draft">Draft</option>
                            <option value="buka">Buka</option>
                            <option value="tutup">Tutup</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="bi bi-arrow-left-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#nama').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Nama Pelatihan',
                allowClear: true
            });
        });
    </script>
@endsection
