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
            <h2 class="mb-0">Hasil Usulan Kebutuhan Pelatihan</h2>
        </div>

        <div class="card mb-4">
            <div class="table-responsive rounded overflow-hidden">
                <table class="table table-bordered mb-0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle;">Tahun</th>
                            <th style="vertical-align: middle;">Nama Pelatihan</th>
                            <th style="vertical-align: middle;">Status</th>
                            <th style="vertical-align: middle;">Tanggal Pelaksanaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemsPerPage = 10;
                            $currentPage = request()->get('page', 1);
                            $usulan = [
                                [
                                    'tahun' => '2025',
                                    'nama_pelatihan' => 'Pelatihan A',
                                    'status' => 'Disetujui',
                                    'tanggal' => '2023-10-01 - 2023-10-20',
                                ],
                                [
                                    'tahun' => '2025',
                                    'nama_pelatihan' => 'Pelatihan B',
                                    'status' => 'Ditolak',
                                    'tanggal' => '-',
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
                                    @if ($item['status'] == 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item['tanggal'] }}</td>
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
    </section>
@endsection
