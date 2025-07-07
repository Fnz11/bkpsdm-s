@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Data Kepegawaian - BKPSDM')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Kepegawaian</li>
    </ol>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 bg-transparent">
            <!-- Navigation & Actions -->
            <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-5">
                <!-- Title -->
                <div>
                    <h4 class="fw-bold mb-1">Data Kepegawaian</h4>
                    <p class="text-muted mb-0">Manajemen data kepegawaian BKPSDM</p>
                </div>

                <!-- Search & Add Button -->
                <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari pegawai...">
                    </div>
                    <a href="{{ route('Dashboard.pelatihan.kepegawaian.create') }}" 
                       class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah</span>
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="border-bottom bg-light-primary text-muted fw-bold">
                            <th class="min-w-50px text-center">No</th>
                            <th class="min-w-150px">NIP</th>
                            <th class="min-w-100px">BIK</th>
                            <th class="min-w-200px">Nama</th>
                            <th class="min-w-150px">Password</th>
                            <th class="min-w-200px">Jabatan</th>
                            <th class="min-w-100px">Level</th>
                            <th class="min-w-100px">Esselon</th>
                            <th class="min-w-100px">Golongan</th>
                            <th class="min-w-200px">Unit Kerja</th>
                            <th class="min-w-100px text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dummyData = [
                                [
                                    'id' => 1,
                                    'nip' => '198505152010011001',
                                    'bik' => 'BK001',
                                    'nama' => 'Ahmad Fauzi',
                                    'password' => '********',
                                    'jabatan' => 'Kepala Seksi Pengembangan',
                                    'level' => 'Admin',
                                    'esselon' => 'III.a',
                                    'golongan' => 'III/d',
                                    'unit_kerja' => 'BKPSDM Kota Surakarta',
                                ],
                                [
                                    'id' => 2,
                                    'nip' => '199001202015032002',
                                    'bik' => 'BK002',
                                    'nama' => 'Siti Rahayu',
                                    'password' => '********',
                                    'jabatan' => 'Analis SDM',
                                    'level' => 'User',
                                    'esselon' => 'IV.a',
                                    'golongan' => 'III/b',
                                    'unit_kerja' => 'BKPSDM Kota Surakarta',
                                ],
                            ];
                        @endphp

                        @foreach ($dummyData as $index => $item)
                            <tr class="border-bottom cursor-pointer" 
                                onclick="window.location.href='{{ route('Dashboard.pelatihan.kepegawaian.edit', $item['id'] ?? 1) }}'">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item['nip'] }}</td>
                                <td>{{ $item['bik'] }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['password'] }}</td>
                                <td>{{ $item['jabatan'] }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $item['level'] === 'Admin' ? 'primary' : 'info' }}">
                                        {{ $item['level'] }}
                                    </span>
                                </td>
                                <td>{{ $item['esselon'] }}</td>
                                <td>{{ $item['golongan'] }}</td>
                                <td>{{ $item['unit_kerja'] }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('Dashboard.pelatihan.kepegawaian.edit', $item['id'] ?? 1) }}" 
                                           class="btn btn-icon btn-sm btn-light-primary" 
                                           data-bs-toggle="tooltip"
                                           title="Edit"
                                           onclick="event.stopPropagation()">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-light-danger" 
                                                data-bs-toggle="tooltip"
                                                title="Hapus"
                                                onclick="event.stopPropagation()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        /* Utility Classes */
        .w-md-150px {
            width: 150px !important;
        }

        .w-md-250px {
            width: 250px !important;
        }

        .h-6px {
            height: 6px !important;
        }

        .ps-10 {
            padding-left: 2.75rem !important;
        }

        /* Form Controls */
        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        .form-control-solid:focus {
            background-color: #eef3f7;
            border-color: #eef3f7;
        }

        .form-select-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        /* Table Styling */
        .table> :not(:first-child) {
            border-top: none;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
        }

        /* Badge Styling */
        .badge {
            padding: 0.5em 0.9em;
            font-weight: 500;
        }

        .badge-success {
            background-color: #50cd89;
            color: #fff;
        }

        .badge-danger {
            background-color: #f1416c;
            color: #fff;
        }

        .badge-light-primary {
            background-color: #f1faff;
            color: #009ef7;
        }

        .badge-light-dark {
            background-color: #f5f8fa;
            color: #5e6278;
        }

        /* Button States */
        .btn-light-primary {
            background-color: #f1faff;
            border-color: transparent;
            color: #009ef7;
        }

        .btn-light-primary:hover {
            background-color: #009ef7;
            color: #fff;
        }

        .btn-light-success {
            background-color: #e8fff3;
            border-color: transparent;
            color: #50cd89;
        }

        .btn-light-success:hover {
            background-color: #50cd89;
            color: #fff;
        }

        .btn-light-info {
            background-color: #f8f5ff;
            border-color: transparent;
            color: #7239ea;
        }

        .btn-light-info:hover {
            background-color: #7239ea;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .w-md-150px,
            .w-md-250px {
                width: 100% !important;
            }
        }

        /* Print Styles */
        @media print {

            .btn,
            .form-control {
                display: none;
            }
        }

        /* Row Click Styling */
        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
