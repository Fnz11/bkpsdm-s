@extends('layouts.app')

@section('content')
    <section>
                <div class="bg-primary text-white p-4 position-relative overflow-hidden bg-primary-section mb-2">
            <!-- Elemen dekoratif (seperti roket) di pojok kanan -->
            <div class="position-absolute end-0 top-0 opacity-75">
                <img src="{{ asset('images/roketDashboard.png') }}" alt="Illustration" height="150">
            </div>
            <!-- Background pattern dots -->
            <div class="position-absolute w-100 h-100 top-0 start-0"
                style="background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;">
            </div>

            <div class="container position-relative">
                <h4 class="fw-bold mb-2">Data Usulan Pelatihan Umum</h4>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-2 mt-2">
                <select class="form-select" id="tahun">
                    <option selected disabled>Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari..." id="searchInput">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-end mt-2">
                <button type="button" class="btn me-2" style="box-shadow: 0 0 10px rgba(0, 0, 0, 25%);">
                    <i class="bi bi-cloud-download me-2"></i>Import
                </button>
                <button type="button" class="btn btn-outline-success me-2">
                    <i class="fas fa-file-excel me-2"></i>Excel
                </button>
                <button type="button" class="btn btn-outline-danger me-2" onclick="cetakPDF()">
                    <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPertanyaan">
                    <i class="bi bi-plus-lg me-2"></i>Tambah
                </button>
            </div>
        </div>

        <div style="position: relative;">
            <div class="table-responsive" style="max-height: 100%; overflow-y: auto; background-color: white;">
                <table class="table table-bordered mb-0">
                    <thead class="">
                        <tr class="text-center">
                            <th style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle;">Tahun</th>
                            <th style="vertical-align: middle;">Nama</th>
                            <th style="vertical-align: middle;">Nama Pelatihan</th>
                            <th style="vertical-align: middle;">Status</th>
                            <th
                                style="position: sticky; right: 0; z-index: 2; background-color: #f8f9fa; vertical-align: middle;">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemsPerPage = 10;
                            $currentPage = request()->get('page', 1);
                            $kompetensi = [
                                [
                                    'Tahun' => '2025',
                                    'Nama' => 'Sulthan Syahrul',
                                    'Nama_Pelatihan' => 'Pelatihan Teknologi Informasi',
                                    'Status' => 'Ditolak',
                                ],
                                [
                                    'Tahun' => '2025',
                                    'Nama' => 'Rizky Maulana',
                                    'Nama_Pelatihan' => 'Pelatihan Kesehatan Masyarakat',
                                    'Status' => 'Diterima',
                                ],
                                [
                                    'Tahun' => '2025',
                                    'Nama' => 'Aulia Rahman',
                                    'Nama_Pelatihan' => 'Pelatihan Kepemimpinan',
                                    'Status' => 'Ditolak',
                                ],
                            ];

                            $totalPages = ceil(count($kompetensi) / $itemsPerPage);
                            $start = ($currentPage - 1) * $itemsPerPage;
                            $paginatedKompetensi = array_slice($kompetensi, $start, $itemsPerPage);
                        @endphp

                        @foreach ($paginatedKompetensi as $index => $item)
                            <tr class="text-center">
                                <td>{{ $start + $index + 1 }}</td>
                                <td style="white-space: nowrap;">{{ $item['Tahun'] }}</td>
                                <td>{{ $item['Nama'] }}</td>
                                <td style="white-space: nowrap;">{{ $item['Nama_Pelatihan'] }}</td>
                                <td class="text-center">
                                    @if ($item['Status'] == 'Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center justify-content-center"
                                    style="position: sticky; right: 0; z-index: 1; background-color: white;">
                                    <button class="btn btn-sm btn-primary me-2" title="Edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEditUsulan">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Fixed Pagination --}}
            <div style="position: sticky; bottom: 0; background-color: white; ">
                <div class="d-flex justify-content-start p-2">
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $totalPages; $i++)
                                <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection
