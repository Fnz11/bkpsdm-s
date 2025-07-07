@extends('layouts.akpkLayouts.akpk')

@section('content')
    <div class="container py-5">

        <div class="row g-4">
            <!-- Left Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100"
                    style="background: linear-gradient(to bottom right, #E8F0FC, #AFCBF4);">
                    <div class="card-body d-flex flex-column align-items-center p-4">
                        <div class="position-relative mb-4">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Profile Photo"
                                class="rounded-circle img-thumbnail shadow-sm" width="150" height="150">
                            <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle">
                                <i class="bi bi-camera-fill"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <h4 class="fw-bold mb-1">Ahmad Subarjo</h4>
                            <p class="text-muted mb-4">Dinas Komunikasi dan Informatika</p>
                        </div>

                        <div class="w-100 mt-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">NIP</label>
                                <input type="text" class="form-control bg-white" value="198505152010011022" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Pangkat/Golongan</label>
                                <input type="text" class="form-control bg-white" value="Penata / III-c" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Jenis Jabatan</label>
                                <input type="text" class="form-control bg-white" value="Fungsional" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Jabatan</label>
                                <input type="text" class="form-control bg-white" value="Pranata Komputer Ahli Muda"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center mb-4">
                            <img src="images/iconJudul.svg" alt="Icon" class="me-2"
                                style="width: 24px; height: 24px;">
                            <h2 class="mb-0">Halaman Profil</h2>
                        </div>
                        <button class="btn btn-primary">
                            <i class="bi bi-pencil-square me-1"></i> Edit Profil
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Unit Kerja</label>
                                    <input type="text" class="form-control" value="Bidang Aplikasi Informatika" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Nama Atasan</label>
                                    <input type="text" class="form-control" value="Ir. Bambang Sutrisno, M.T." readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Uraian Tugas</label>
                                    <textarea class="form-control" rows="3" readonly>Melakukan perencanaan, pengembangan, dan pemeliharaan sistem aplikasi di lingkungan pemerintah daerah sesuai dengan standar dan prosedur yang berlaku.</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Tempat Tanggal Lahir</label>
                                    <input type="text" class="form-control" value="Jakarta, 15 Mei 1985" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">No. HP</label>
                                    <input type="text" class="form-control" value="081234567890" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Email</label>
                                    <input type="email" class="form-control" value="ahmad.subarjo@pemda.go.id" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Alamat</label>
                                    <input type="text" class="form-control"
                                        value="Jl. Merdeka No. 123, Kota Administratif" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
