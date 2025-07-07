@extends('layouts.akpkLayouts.akpk')

<style>
    thead.bg-primary th {
        background-color: #C1D6F7 !important;
    }

    .table-bordered {
        border: none;
    }

    .rounded .table-bordered thead th:first-child {
        border-top-left-radius: 0.25rem;
    }

    .rounded .table-bordered thead th:last-child {
        border-top-right-radius: 0.25rem;
    }
</style>

@section('content')
    <section class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="images/iconJudul.svg" alt="Icon" class="me-2" style="width: 24px; height: 24px;">
            <h2 class="mb-0">Nomenklatur</h2>
        </div>

        <!-- button dan form  -->
        <div class="row gy-2 mb-3">
            <div class="col-12 col-md-2">
                <select class="form-select" id="rumpun">
                    <option selected disabled>Pilih Rumpun</option>
                    <option value="Kepemimpinan">Kepemimpinan</option>
                    <option value="Manajerial">Manajerial</option>
                    <option value="Teknis">Teknis</option>
                    <option value="Fungsional">Fungsional</option>
                    <option value="Sosial Kultural">Sosial Kultural</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-6 d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/cetak" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                </a>
                <a href="/usulan" class="btn btn-success">
                    <i class="bi bi-arrow-right-square-fill"></i> Usul Pelatihan
                </a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahNomenklatur">
                    <i class="bi bi-plus-lg"></i> Tambah nomenklatur
                </button>
            </div>
        </div>



        <div class="card mb-4">
            <div class="table-responsive rounded overflow-hidden">
                <table class="table table-bordered mb-0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle;">Rumpun</th>
                            <th style="vertical-align: middle;">Nama Pelatihan</th>
                            <th style="vertical-align: middle;">Status</th>
                            <th style="vertical-align: middle;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemsPerPage = 10;
                            $currentPage = request()->get('page', 1);
                            $Nomenklatur = [
                                [
                                    'id' => 1,
                                    'rumpun' => 'Kepemimpinan',
                                    'nama_pelatihan' => 'Pelatihan Kepemimpinan Administrator',
                                    'status' => 'diterima',
                                ],
                                [
                                    'id' => 2,
                                    'rumpun' => 'Manajerial',
                                    'nama_pelatihan' => 'Pelatihan Manajemen SDM',
                                    'status' => 'ditolak',
                                ],
                            ];
                            $totalPages = ceil(count($Nomenklatur) / $itemsPerPage);
                            $start = ($currentPage - 1) * $itemsPerPage;
                            $paginatedNomenklatur = array_slice($Nomenklatur, $start, $itemsPerPage);
                        @endphp

                        @foreach ($paginatedNomenklatur as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item['rumpun'] }}</td>
                                <td>{{ $item['nama_pelatihan'] }}</td>
                                <td class="text-center">
                                    @if ($item['status'] == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item['status'] == 'ditolak')
                                        <span>Pelatihan sudah tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="card-footer" style="background-color: #C1D6F7">
                <div class="d-flex justify-content-center">
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
                                    <span aria-hidden="true">Net &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        @include('MenuUmum.Akpk.UsulanPelatihan.Nomenklatur.tambahNomenklatur')
    </section>

    <script>
        function cetakPDF() {
            // Add your PDF export logic here
            alert('Ekspor ke PDF');
        }
    </script>
@endsection
