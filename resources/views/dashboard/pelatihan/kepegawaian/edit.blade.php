@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Pegawai - BKPSDM')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.kepegawaian.index') }}">Data Kepegawaian</a></li>
        <li class="breadcrumb-item active">Edit Pegawai</li>
    </ol>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 bg-transparent">
            <div class="d-flex flex-column">
                <h4 class="fw-bold mb-1">Edit Data Pegawai</h4>
                <p class="text-muted mb-0">Perbarui data pegawai melalui formulir berikut</p>
            </div>
        </div>

        <div class="card-body">
            <!-- Wizard Progress -->
            <div class="d-flex justify-content-between mb-5">
                <div class="w-100 d-flex gap-3">
                    <button class="btn btn-primary flex-grow-1 step-btn active" data-step="1">Data Pribadi</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="2">Data Kepegawaian</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="3">Akun & Akses</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="4">Review</button>
                </div>
            </div>

            <!-- Form with dummy data -->
            <form id="wizardForm" action="#" method="POST">
                @csrf
                @method('PUT')

                <!-- Step 1: Data Pribadi -->
                <div class="wizard-step active" data-step="1">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-solid" name="nama" value="Ahmad Fauzi"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" class="form-control form-control-solid" name="nip"
                                value="198505152010011001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">BIK</label>
                            <input type="text" class="form-control form-control-solid" name="bik" value="BK001"
                                required>
                        </div>
                        <!-- ... same structure as create.blade.php with filled values ... -->
                    </div>
                </div>

                <!-- Step 2: Data Kepegawaian -->
                <div class="wizard-step" data-step="2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" class="form-control form-control-solid" name="jabatan"
                                value="Kepala Seksi Pengembangan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit Kerja</label>
                            <input type="text" class="form-control form-control-solid" name="unit_kerja"
                                value="BKPSDM Kota Surakarta" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Esselon</label>
                            <select class="form-select form-select-solid" name="esselon" required>
                                <option value="">Pilih Esselon</option>
                                <option value="II.a">II.a</option>
                                <option value="III.a" selected>III.a</option>
                                <option value="IV.a">IV.a</option>
                            </select>
                        </div>
                        <!-- ... same structure as create.blade.php with filled values ... -->
                    </div>
                </div>

                <!-- Step 3: Akun & Akses -->
                <div class="wizard-step" data-step="3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control form-control-solid" name="password"
                                placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control form-control-solid" name="password_confirmation"
                                placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Level Akses</label>
                            <select class="form-select form-select-solid" name="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin" selected>Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Review -->
                <div class="wizard-step" data-step="4">
                    <div class="row g-4">
                        <div class="col-12">
                            <h5 class="fw-bold mb-4">Review Perubahan Data</h5>
                            <div id="reviewData" class="table-responsive">
                                <!-- Will be filled dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-5">
                    <button type="button" class="btn btn-light prev-step" style="display: none;">
                        <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                    </button>
                    <button type="button" class="btn btn-primary next-step">
                        Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-success submit-form" style="display: none;">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        // ...copy styles from create.blade.php...
    </style>

    <script>
        // ...copy scripts from create.blade.php...
    </script>
@endsection
