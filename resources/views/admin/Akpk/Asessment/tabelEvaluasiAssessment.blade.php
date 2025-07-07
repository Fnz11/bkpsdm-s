@extends('layouts.app')

@section('content')
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
            <h4 class="fw-bold mb-2">Hasil Evaluasi Assessment</h4>
        </div>
    </div>

    <div class="">
        {{-- Button dan Filter --}}
        <div class="row mb-3 align-items-center">
            <div class="col-md-2 mt-2">
                <select class="form-select" id="rumpun" style="box-shadow: 0 0 10px rgba(0, 0, 0, 25%);">
                    <option selected disabled>Pilih Unit Kerja</option>
                    <option value="BKPSDM">BKPSDM</option>
                    <option value="Kemenkes">Kementerian Kesehatan</option>
                    <option value="Kominfo">Kementerian Komunikasi dan Informasi</option>
                    <option value="Kemenag">Kementerian</option>
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
            </div>
        </div>
    </div>

    {{-- Tabel dengan Fixed Pagination --}}
    <div style="position: relative;">
        <div class="table-responsive" style="max-height: 100%; overflow-y: auto; background-color: white;">
            <table class="table table-bordered mb-0">
                <thead class="">
                    <tr class="text-center">
                        <th rowspan="2" style="vertical-align: middle;">No</th>
                        <th rowspan="2" style="vertical-align: middle;">Tanggal</th>
                        <th rowspan="2" style="vertical-align: middle;">NIP Atasan</th>
                        <th rowspan="2" style="vertical-align: middle;">Nama Atasan</th>
                        <th rowspan="2" style="vertical-align: middle;">NIP Bawahan</th>
                        <th rowspan="2" style="vertical-align: middle;">Nama Bawahan</th>
                        <th rowspan="2" style="vertical-align: middle;">Jabatan</th>
                        <th rowspan="2" style="vertical-align: middle;">Unit Kerja</th>
                        <th rowspan="2" style="vertical-align: middle;">Standar<br> Kompetensi</th>
                        <th colspan="10" style="vertical-align: middle;">Penilaian Self Assessment</th>
                        <th colspan="10" style="vertical-align: middle;">Penilaian Atasan</th>
                        <th rowspan="2"
                            style="position: sticky; right: 0; z-index: 2; background-color: #f8f9fa; vertical-align: middle;">
                            Action</th>
                    </tr>
                    <tr class="text-center">
                        <!-- Self Assessment -->
                        <th style="vertical-align: middle;">Integritas</th>
                        <th style="vertical-align: middle;">Kerjasama</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Orientasi<br>Hasil</th>
                        <th style="vertical-align: middle;">Pelayanan<br>Publik</th>
                        <th style="vertical-align: middle;">Pengembangan<br>Diri</th>
                        <th style="vertical-align: middle;">Mengelola<br>Perubahan</th>
                        <th style="vertical-align: middle;">Pengambilan<br>Keputusan</th>
                        <th style="vertical-align: middle;">Penguasaan<br>Teknologi</th>
                        <th style="vertical-align: middle;">Keahlian<br>Spesifik</th>
                        <!-- Penilaian Atasan -->
                        <th style="vertical-align: middle;">Integritas</th>
                        <th style="vertical-align: middle;">Kerjasama</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Orientasi<br>Hasil</th>
                        <th style="vertical-align: middle;">Pelayanan<br>Publik</th>
                        <th style="vertical-align: middle;">Pengembangan<br>Diri</th>
                        <th style="vertical-align: middle;">Mengelola<br>Perubahan</th>
                        <th style="vertical-align: middle;">Pengambilan<br>Keputusan</th>
                        <th style="vertical-align: middle;">Penguasaan<br>Teknologi</th>
                        <th style="vertical-align: middle;">Keahlian<br>Spesifik</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $itemsPerPage = 10;
                        $currentPage = request()->get('page', 1);
                        $kompetensi = [
                            [
                                'Tanggal' => '2023-10-01',
                                'NIP' => '1987654321',
                                'nama' => 'Nanang Ardiansyah',
                                'NIP_bawahan' => '212121212121',
                                'nama_bawahan' => 'Putra Pamungkas',
                                'jabatan' => 'Analis Kepegawaian',
                                'unit_kerja' => 'Biro Kepegawaian',
                                'standar_minimal' => 3,
                                // Self Assessment
                                'self_integritas' => 4,
                                'self_kerjasama' => 3,
                                'self_kepemimpinan' => 4,
                                'self_orientasi_hasil' => 3,
                                'self_pelayanan_publik' => 4,
                                'self_pengembangan_diri' => 3,
                                'self_mengelola_perubahan' => 4,
                                'self_pengambilan_keputusan' => 3,
                                'self_penguasaan_teknologi' => 4,
                                'self_keahlian_spesifik' => 3,
                                // Supervisor Assessment
                                'atasan_integritas' => 3,
                                'atasan_kerjasama' => 4,
                                'atasan_kepemimpinan' => 3,
                                'atasan_orientasi_hasil' => 4,
                                'atasan_pelayanan_publik' => 3,
                                'atasan_pengembangan_diri' => 4,
                                'atasan_mengelola_perubahan' => 3,
                                'atasan_pengambilan_keputusan' => 4,
                                'atasan_penguasaan_teknologi' => 3,
                                'atasan_keahlian_spesifik' => 4,
                            ],
                        ];

                        $totalPages = ceil(count($kompetensi) / $itemsPerPage);
                        $start = ($currentPage - 1) * $itemsPerPage;
                        $paginatedKompetensi = array_slice($kompetensi, $start, $itemsPerPage);
                    @endphp

                    @foreach ($paginatedKompetensi as $index => $item)
                        <tr class="text-center">
                            <td>{{ $start + $index + 1 }}</td>
                            <td style="white-space: nowrap;">{{ $item['Tanggal'] }}</td>
                            <td>{{ $item['NIP'] }}</td>
                            <td style="white-space: nowrap;">{{ $item['nama'] }}</td>
                            <td>{{ $item['NIP_bawahan'] }}</td>
                            <td style="white-space: nowrap;">{{ $item['nama_bawahan'] }}</td>
                            <td style="white-space: nowrap;">{{ $item['jabatan'] }}</td>
                            <td style="white-space: nowrap;">{{ $item['unit_kerja'] }}</td>
                            <td>{{ $item['standar_minimal'] }}</td>
                            <!-- Self Assessment Values -->
                            <td>{{ $item['self_integritas'] }}</td>
                            <td>{{ $item['self_kerjasama'] }}</td>
                            <td>{{ $item['self_kepemimpinan'] }}</td>
                            <td>{{ $item['self_orientasi_hasil'] }}</td>
                            <td>{{ $item['self_pelayanan_publik'] }}</td>
                            <td>{{ $item['self_pengembangan_diri'] }}</td>
                            <td>{{ $item['self_mengelola_perubahan'] }}</td>
                            <td>{{ $item['self_pengambilan_keputusan'] }}</td>
                            <td>{{ $item['self_penguasaan_teknologi'] }}</td>
                            <td>{{ $item['self_keahlian_spesifik'] }}</td>
                            <!-- Supervisor Assessment Values -->
                            <td>{{ $item['atasan_integritas'] }}</td>
                            <td>{{ $item['atasan_kerjasama'] }}</td>
                            <td>{{ $item['atasan_kepemimpinan'] }}</td>
                            <td>{{ $item['atasan_orientasi_hasil'] }}</td>
                            <td>{{ $item['atasan_pelayanan_publik'] }}</td>
                            <td>{{ $item['atasan_pengembangan_diri'] }}</td>
                            <td>{{ $item['atasan_mengelola_perubahan'] }}</td>
                            <td>{{ $item['atasan_pengambilan_keputusan'] }}</td>
                            <td>{{ $item['atasan_penguasaan_teknologi'] }}</td>
                            <td>{{ $item['atasan_keahlian_spesifik'] }}</td>
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
        <div style="position: sticky; bottom: 0; background-color: white; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
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
@endsection
