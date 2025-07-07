@extends('layouts.app')

@section('content')
    <div class="">

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
                <h4 class="fw-bold mb-2">Hasil Self Assessment</h4>
            </div>
        </div>

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
                        <th style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle;">Tanggal</th>
                        <th style="vertical-align: middle;">NIP</th>
                        <th style="vertical-align: middle;">Nama Bawahan</th>
                        <th style="vertical-align: middle;">Jabatan</th>
                        <th style="vertical-align: middle;">Unit Kerja</th>
                        <th style="vertical-align: middle;">Standar<br> Kompetensi</th>
                        <th style="vertical-align: middle;">Integritas</th>
                        <th style="vertical-align: middle;">Kerjasama</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Orientasi <br> Hasil</th>
                        <th style="vertical-align: middle;">Pelayanan <br> Publik</th>
                        <th style="vertical-align: middle;">Pengembangan <br> Diri</th>
                        <th style="vertical-align: middle;">Mengelola <br> Perubahan</th>
                        <th style="vertical-align: middle;">Pengambilan <br> Keputusan</th>
                        <th style="vertical-align: middle;">Penguasaan <br> Teknologi</th>
                        <th style="vertical-align: middle;">Keahlian <br> Spesifik</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
                        <th style="vertical-align: middle;">Kepemimpinan</th>
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
                                'Tanggal' => '2023-10-01',
                                'NIP' => '1987654321',
                                'nama' => 'Nanang Ardiansyah',
                                'jabatan' => 'Analis Kepegawaian',
                                'unit_kerja' => 'Biro Kepegawaian',
                                'standar_minimal' => 3,
                                'integritas' => 4,
                                'kerjasama' => 3,
                                'kepemimpinan' => 4,
                                'orientasi_hasil' => 3,
                                'pelayanan_publik' => 4,
                                'pengembangan_diri' => 3,
                                'mengelola_perubahan' => 4,
                                'pengambilan_keputusan' => 3,
                                'penguasaan_teknologi' => 4,
                                'keahlian_spesifik' => 3,
                                'kepemimpinan' => 4,
                                'kepemimpinan' => 3,
                                'kepemimpinan' => 4,
                                'kepemimpinan' => 3,
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
                            <td style="white-space: nowrap;">{{ $item['jabatan'] }}</td>
                            <td style="white-space: nowrap;">{{ $item['unit_kerja'] }}</td>
                            <td>{{ $item['standar_minimal'] }}</td>
                            <td>{{ $item['integritas'] }}</td>
                            <td>{{ $item['kerjasama'] }}</td>
                            <td>{{ $item['kepemimpinan'] }}</td>
                            <td>{{ $item['orientasi_hasil'] }}</td>
                            <td>{{ $item['pelayanan_publik'] }}</td>
                            <td>{{ $item['pengembangan_diri'] }}</td>
                            <td>{{ $item['mengelola_perubahan'] }}</td>
                            <td>{{ $item['pengambilan_keputusan'] }}</td>
                            <td>{{ $item['penguasaan_teknologi'] }}</td>
                            <td>{{ $item['keahlian_spesifik'] }}</td>
                            <td>{{ $item['kepemimpinan'] }}</td>
                            <td>{{ $item['kepemimpinan'] }}</td>
                            <td>{{ $item['kepemimpinan'] }}</td>
                            <td>{{ $item['kepemimpinan'] }}</td>
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
