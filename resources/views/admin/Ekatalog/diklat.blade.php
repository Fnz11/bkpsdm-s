@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4 text-center">E-Katalog Diklat</h2>

        <!-- Search Bar and Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" action="{{ route('admin.ekatalog.diklat') }}" class="d-flex w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari pelatihan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>
            
            <!-- Buttons -->
            <div>
                <a href="{{ route('admin.ekatalog.creatediklat') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah
                </a>
                <a href="{{ route('exportekatalog.excel') }}" class="btn btn-success">
                    <i class="fa fa-file-export"></i> Export
                </a>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fa fa-file-import"></i> Import
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Jenis Pelatihan</th>
                        <th>Nama Pelatihan</th>
                        <th>Rumpun</th>
                        <th>Penyelenggara</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Link Katalog</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diklats as $index => $diklat)
                        <tr>
                            <td>{{ $loop->iteration + ($diklats->currentPage() - 1) * $diklats->perPage() }}</td>
                            <td>{{ $diklat->jenis_pelatihan }}</td>
                            <td>{{ $diklat->nama_pelatihan }}</td>
                            <td>{{ $diklat->rumpun_pelatihan }}</td>
                            <td>{{ $diklat->nama_penyelenggara }}</td>
                            <td>{{ $diklat->no_HP }}</td>
                            <td>
                                <span class="badge bg-{{ $diklat->status == 'visible' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($diklat->status) }}
                                </span>
                            </td>
                            <td>
                                @if($diklat->link_katalog)
                                    <a href="{{ $diklat->link_katalog }}" target="_blank" class="btn btn-sm btn-link">Lihat</a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.ekatalog.viewdiklat', ['id' => $diklat->id]) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('deleteekatalog', $diklat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form action="{{ route('toggle.status', $diklat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $diklat->status == 'visible' ? 'btn-secondary' : 'btn-success' }}">
                                        <i class="fa {{ $diklat->status == 'visible' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data pelatihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $diklats->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="import-form" action="{{ route('import.diklat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file-input" class="form-label">Pilih file untuk diimport</label>
                        <input type="file" name="file" id="file-input" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
