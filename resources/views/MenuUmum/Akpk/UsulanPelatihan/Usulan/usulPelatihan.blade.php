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
            <h2 class="mb-0">Usulan Kebutuhan Pelatihan</h2>
        </div>

        <!-- button dan form  -->
        <div class="row gy-2 mb-3">
            <div class="col-12 col-md-2">
                <select class="form-select" id="tahun">
                    <option selected disabled>Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
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
            <div class="col-12 col-md-6 text-md-end d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/nomenklatur" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Cek Nomenklatur
                </a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUsulan">
                    <i class="bi bi-plus-lg"></i> Tambah Usulan
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="table-responsive rounded overflow-hidden">
                <table class="table table-bordered mb-0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle;">Tahun</th>
                            <th style="vertical-align: middle;">Nama Pelatihan</th>
                            <th style="vertical-align: middle;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemsPerPage = 10;
                            $currentPage = request()->get('page', 1);
                            $usulan = [
                                [
                                    'id' => 1,
                                    'tahun' => '2023',
                                    'nama_pelatihan' => 'Pelatihan Kepemimpinan Administrator',
                                ],
                                [
                                    'id' => 2,
                                    'tahun' => '2023',
                                    'nama_pelatihan' => 'Pelatihan Manajemen SDM',
                                ],
                            ];
                            $totalPages = ceil(count($usulan) / $itemsPerPage);
                            $start = ($currentPage - 1) * $itemsPerPage;
                            $paginatedUsulan = array_slice($usulan, $start, $itemsPerPage);
                        @endphp

                        @foreach ($paginatedUsulan as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item['tahun'] }}</td>
                                <td>{{ $item['nama_pelatihan'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning me-1" title="Edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEditUsulan" data-id="{{ $item['id'] }}"
                                        data-tahun="{{ $item['tahun'] }}" data-nama="{{ $item['nama_pelatihan'] }}">
                                        <i class="bi bi-pencil-square"></i>
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

        <!-- Include modal forms -->
        @include('MenuUmum.Akpk.UsulanPelatihan.Usulan.tambahUsulPelatihan')
        @include('MenuUmum.Akpk.UsulanPelatihan.Usulan.editUsulPelatihan')

    </section>
@endsection
