@extends('layouts.app')
@section('head')
<style>
    .content-container {
        background-color: #E9ECEF;
    }
    .bg-primary-section {
        background-color: #1a66ff;
        padding: 25px 0;
    }
    .card {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    /* Fix for progress background color */
    .card .progress {
        background-color: #DDE7FF !important;
        height: 34px !important;
        border-radius: 6px;
    }
    /* Ensure this rule has higher specificity */
    .card-body .progress {
        background-color: #DDE7FF !important;
    }
    .progress-bar {
        background-color: #0d6efd;
    }
    .card-pelatihan {
        background-color: #0d6efd;
        color: white;
        border-radius: 8px;
    }
    .table th {
        font-weight: 500;
        color: #6c757d;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    .year-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .year-text {
        color: #6c757d;
        margin-right: 15px;
        font-size: 0.9rem;
    }
    .year-active {
        color: #0d6efd;
        font-weight: bold;
    }
    .eye-icon {
        color: #0d6efd;
    }
    .sort-icon {
        font-size: 12px;
        color: #6c757d;
    }
    .pelatihan-box {
        background-color: #0d6efd !important;
        border-radius: 8px;
        padding: 20px 15px;
        color: white !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        display: block;
        width: 100%;
        position: relative;
    }
    .pelatihan-progress {
        background-color: rgba(255, 255, 255, 0.3);
        height: 8px;
        border-radius: 4px;
        margin-top: 10px;
        position: relative;
    }
    .pelatihan-progress-bar {
        background-color: white;
        height: 8px;
        border-radius: 4px;
    }
    .btn-outline-primary.text-black {
        color: black !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0 content-container main-content">
    <!-- Header dengan background biru -->
    <div class="bg-primary text-white p-4 position-relative overflow-hidden bg-primary-section">
        <!-- Elemen dekoratif (seperti roket) di pojok kanan -->
        <div class="position-absolute end-0 top-0 opacity-25">
            <i class="bi bi-rocket-takeoff" style="font-size: 5rem;"></i>
        </div>
        <!-- Background pattern dots -->
        <div class="position-absolute w-100 h-100 top-0 start-0" style="background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="container position-relative">
            <h4 class="fw-bold mb-2">Usulan Pelatihan Solowasis</h4>
        </div>
    </div>

    <div class="container py-4">
        <div class="row">
            <!-- Card Hasil Analisis -->
            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="text-primary fw-bold mb-4">Hasil Analisis Usulan Pelatihan Solowasis</h5>
                        
                        @php
                            $chartData = [
                                ['label' => 'Public Speaking', 'value' => 85],
                                ['label' => 'Leadership', 'value' => 46],
                                ['label' => 'Digital Marketing', 'value' => 38],
                                ['label' => 'Data Science', 'value' => 17],
                                ['label' => 'Bahasa Inggris', 'value' => 3],
                            ];
                        @endphp
                        
                        @foreach ($chartData as $data)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $data['label'] }}</span>
                                    <span>{{ $data['value'] }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $data['value'] }}%;" aria-valuenow="{{ $data['value'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Card Pelatihan Terpilih -->
            @php
                $selectedPelatihan = ['name' => 'Public Speaking', 'votes' => 85, 'percentage' => 39];
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card h-100 bg-light p-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-2">Pelatihan Terpilih</h5>
                        <p class="text-muted small mb-3">Usulan yang akan diadakan tahun depan</p>
            
                        <!-- Box Biru -->
                        <div class="pelatihan-box mb-4 position-relative">
                            <h5 class="fw-bold mb-1">{{ $selectedPelatihan['name'] }}</h5>
                            <p class="small mb-3">{{ $selectedPelatihan['votes'] }} pilihan</p>
            
                            <!-- Updated Progress Bar -->
                            <div class="pelatihan-progress position-relative">
                                <div class="pelatihan-progress-bar" style="width: {{ $selectedPelatihan['percentage'] }}%;"></div>
                            
                                <div class="position-absolute top-0 start-50 translate-middle badge bg-white text-primary" style="font-size: 12px; margin-top: -16px;">
                                    {{ $selectedPelatihan['percentage'] }}%
                                </div>
                            </div>
                        </div>
            
                        <!-- Tahun -->
                        <div class="text-center mt-4">
                            <span class="d-inline-block me-3">
                                <span class="year-dot bg-secondary"></span>
                                <span class="year-text">2023</span>
                            </span>
                            <span class="d-inline-block me-3">
                                <span class="year-dot bg-primary"></span>
                                <span class="year-text">2024</span>
                            </span>
                            <span class="d-inline-block">
                                <span class="year-dot" style="background-color: #8e44ad;"></span>
                                <span class="year-text year-active">2025</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
        <!-- Daftar Usulan Pelatihan (Title outside the card) -->
        <h5 class="text-primary fw-bold mb-3">Daftar Usulan Pelatihan Solowasis Pegawai</h5>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search">
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <button class="btn btn-outline-secondary me-2">
                            <i class="bi bi-download"></i> Import
                        </button>
                        <button class="btn btn-outline-success me-2">
                            <i class="bi bi-file-excel"></i> Cetak Excel
                        </button>
                        <button class="btn btn-outline-danger me-2">
                            <i class="bi bi-file-pdf"></i> Cetak PDF
                        </button>
                        <button class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tahun <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>NIP <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>Nama <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>Jabatan <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>Unit Kerja <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>Pelatihan Terpilih <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $data = [
                                    ['tahun' => '2025', 'nip' => '198765432109876', 'nama' => 'Nanang Ardiansyah', 'jabatan' => 'Analis SDM', 'unit_kerja' => 'Badan Kepegawaian Daerah', 'pelatihan' => 'Public Speaking'],
                                    ['tahun' => '2025', 'nip' => '197654321098765', 'nama' => 'Nauful Dwi Saputro', 'jabatan' => 'Staf Pelayanan Publik', 'unit_kerja' => 'Dinas Kependudukan dan Catatan Sipil', 'pelatihan' => 'Public Speaking'],
                                    ['tahun' => '2025', 'nip' => '196543210987654', 'nama' => 'Sulthon Syahrul', 'jabatan' => 'Kepala Seksi', 'unit_kerja' => 'Dinas Pendidikan', 'pelatihan' => 'Public Speaking'],
                                    ['tahun' => '2025', 'nip' => '195432109876543', 'nama' => 'Risa Nur Azizah', 'jabatan' => 'Analis Hukum', 'unit_kerja' => 'Bagian Hukum Setda', 'pelatihan' => 'Public Speaking'],
                                    ['tahun' => '2025', 'nip' => '194321098765432', 'nama' => 'Rosita Sabrina', 'jabatan' => 'Staf Administrasi', 'unit_kerja' => 'Sekretariat DPRD', 'pelatihan' => 'Public Speaking'],
                                    ['tahun' => '2025', 'nip' => '193210987654321', 'nama' => 'Nanang', 'jabatan' => 'Pengelola Data', 'unit_kerja' => 'Dinas Komunikasi dan Informatika', 'pelatihan' => 'Manajemen Kinerja'],
                                ];
                            @endphp
                            @foreach ($data as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['tahun'] }}</td>
                                    <td>{{ $row['nip'] }}</td>
                                    <td>{{ $row['nama'] }}</td>
                                    <td>{{ $row['jabatan'] }}</td>
                                    <td>{{ $row['unit_kerja'] }}</td>
                                    <td>{{ $row['pelatihan'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <button class="btn btn-sm btn-link p-0">
                                                <i class="bi bi-eye eye-icon"></i>
                                            </button>
                                            <button class="btn btn-outline-primary text-black">Verifikasi</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">Previous</button>
                        <button class="btn btn-sm btn-outline-secondary">Next</button>
                    </div>
                    <div class="text-muted-small">
                        Page 1 of 10
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection