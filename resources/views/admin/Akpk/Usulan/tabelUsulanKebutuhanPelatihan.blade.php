@extends('layouts.app')
@section('head')
    <style>
        .content-container {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .bg-primary-section {
            background-color: #0d6efd;
            padding-bottom: 1.5rem !important;
        }

        .data-table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: -20px;
        }

        .table th {
            font-weight: 500;
            color: #444;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }

        .table td {
            vertical-align: middle;
        }

        .status-badge {
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .status-terima {
            background-color: rgba(25, 135, 84, 0.15);
            color: #198754;
        }

        .status-revisi {
            background-color: rgba(255, 193, 7, 0.15);
            color: #fd7e14;
        }

        .status-tolak {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .table td .btn-action {
            padding: 2px;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            margin-left: 5px;
        }

        .search-container {
            position: relative;
        }

        .search-container .form-control {
            padding-left: 35px;
            border-radius: 5px;
        }

        .search-container .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btn-outline-excel {
            color: #198754;
            border: 1px solid #198754;
            background-color: transparent;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .btn-outline-pdf {
            color: #dc3545;
            border: 1px solid #dc3545;
            background-color: transparent;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .btn-import {
            color: #212529;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 6px 12px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-previous,
        .btn-next {
            background-color: #fff;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 5px 15px;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0 content-container main-content">
        <!-- Header dengan background biru -->
        <div class="bg-primary text-white p-4 position-relative overflow-hidden bg-primary-section">
            <!-- Elemen dekoratif (seperti roket) di pojok kanan -->
            <div class="position-absolute end-0 top-0 opacity-25">
                <img src="{{ asset('images/roketDashboard.png') }}" alt="Illustration" height="150">
            </div>
            <!-- Background pattern dots -->
            <div class="position-absolute w-100 h-100 top-0 start-0"
                style="background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;">
            </div>

            <div class="container position-relative">
                <h4 class="fw-bold mb-2">Usulan Pelatihan Umum</h4>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Tombol Import, Cetak, dan Tambah -->
            <div class="d-flex justify-content-between mb-3 flex-wrap">
                <div class="input-group mb-2 mb-sm-0" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search">
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-upload me-1"></i> Import
                    </button>
                    <button class="btn btn-success d-flex align-items-center">
                        <i class="bi bi-file-earmark-excel-fill me-1"></i> Cetak Excel
                    </button>
                    <button class="btn btn-danger d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                    </button>
                    <button class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nama</th>
                            <th>Unit Kerja</th>
                            <th>File</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = [
                                [
                                    '2025',
                                    'Nanang Ardiansyah',
                                    'Badan Kepegawaian Daerah',
                                    'Usulan_pelatihan_2025.pdf',
                                    'Terima',
                                ],
                                [
                                    '2025',
                                    'Naufal Dwi Saputro',
                                    'Dinas Kependudukan dan Catatan Sipil',
                                    'Revisi_pelatihan_2025.pdf',
                                    'Terima',
                                ],
                                [
                                    '2025',
                                    'Sulthon Syahrul',
                                    'Dinas Pendidikan',
                                    'Usulan_pelatihan_2025.pdf',
                                    'Revisi',
                                ],
                                [
                                    '2025',
                                    'Risa Nur Azizah',
                                    'Bagian Hukum Setda',
                                    'Revisi_pelatihan_2025.pdf',
                                    'Terima',
                                ],
                                [
                                    '2025',
                                    'Rosita Sabrina',
                                    'Sekretariat DPRD',
                                    'Usulan_pelatihan_2025.pdf',
                                    'Revisi',
                                ],
                                [
                                    '2025',
                                    'Nanang',
                                    'Dinas Komunikasi dan Informatika',
                                    'Usulan_pelatihan_2025.pdf',
                                    'Tolak',
                                ],
                                [
                                    '2025',
                                    'Naufal',
                                    'Inspektorat Daerah',
                                    'Revisi_pelatihan_2025.pdf',
                                    'Tolak',
                                ],
                            ];
                        @endphp
                        @foreach ($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row[0] }}</td>
                                <td>{{ $row[1] }}</td>
                                <td>{{ $row[2] }}</td>
                                <td>{{ $row[3] }}</td>
                                <td>
                                    @if ($row[4] === 'Terima')
                                        <span class="badge bg-success"><i class="bi bi-dot"></i> Terima</span>
                                    @elseif ($row[4] === 'Revisi')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-dot"></i> Revisi</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-dot"></i> Tolak</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center justify-content-center"
                                    style="position: sticky; right: 0; z-index: 1; background-color: white;">
                                    <button class="btn btn-sm btn-outline-primary me-1" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <span class="text-muted">Page 1 of 10</span>
                </div>
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-1">Previous</button>
                    <button class="btn btn-outline-secondary btn-sm">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection
