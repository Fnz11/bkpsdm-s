@extends('layouts.app')



@section('content')
    <div class="">
        <!-- Header Section -->
        <div class="bg-primary text-white p-4 position-relative overflow-hidden">
            <!-- Dotted pattern -->
            <div class="position-absolute w-100 h-100 top-0 start-0"
                style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;">
            </div>
            <!-- Rocket image -->
            <div class="position-absolute end-0 top-0 opacity-25 pe-3 pt-2">
                <img src="{{ asset('images/roketDashboard.png') }}" alt="Rocket" height="150">
            </div>
            <div class="container position-relative">
                <h4 class="fw-bold mb-1">Manajemen Rumpun</h4>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="py-2">
            <div class="mt-2">

                <!-- Tabel Data -->
                <div class="table-responsive bg-white p-3 rounded shadow-sm">
                    <!-- Controls: Search + Buttons -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-upload me-1"></i> Import
                            </button>
                            <button class="btn btn-success">
                                <i class="bi bi-file-earmark-excel-fill me-1"></i> Cetak Excel
                            </button>
                            <button class="btn btn-danger">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                            </button>
                            <button class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> Tambah
                            </button>
                        </div>
                    </div>

                    @php
                        $pelatihans = [
                            ['rumpun' => '2025'],
                        ];

                        // Pagination dummy logic
                        $currentPage = request()->get('page', 1);
                        $perPage = 10;
                        $totalItems = count($pelatihans);
                        $totalPages = ceil($totalItems / $perPage);
                    @endphp

                    <table class="table align-middle mb-0">
                        <thead class="text-center text-white" style="background-color: #6c9eff;">
                            <tr>
                                <th>No</th>
                                <th>Rumpun</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelatihans as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['rumpun'] }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">

                                            <a href="#" class="text-primary"><i class="bi bi-pencil-square"></i></a>
                                            <a href="#" class="text-danger"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"
                                    style="position: sticky; bottom: 0; background-color: white; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); z-index: 10;">
                                    <div class="d-flex justify-content-between align-items-center px-2 py-2">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?page={{ $currentPage - 1 }}"
                                                        aria-label="Previous">
                                                        <span aria-hidden="true">&laquo; Previous</span>
                                                    </a>
                                                </li>
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="?page={{ $i }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?page={{ $currentPage + 1 }}"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">Next &raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="text-muted small">Page {{ $currentPage }} of {{ $totalPages }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
