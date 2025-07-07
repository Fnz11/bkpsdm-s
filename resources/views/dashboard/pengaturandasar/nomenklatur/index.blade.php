@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Nama Pelatihan')

@section('additional-css-pengaturandasar')
@endsection

@section('pengaturandasar-content')
    <div class="card border-0 shadow-sm p-3">
        <div class="card-header border-0 py-3 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari nama pelatihan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Filter Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'nip', 'kode', 'nama', 'jenis', 'status', 'tanggal', 'keterangan', 'aksi'] as $col)
                                <li>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="me-2 toggle-col" data-target="{{ $col }}"
                                            checked>
                                        {{ ucfirst($col) }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Tombol Dropdown Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 600px;">
                            <div class="container-fluid">
                                <!-- Baris Pertama -->
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Jenis</label>
                                        <select name="jenis" id="filter-jenis" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($jenispelatihans as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Status</label>
                                        <select name="status" id="filter-status" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
                                            <option value="proses">Proses</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Baris Kedua -->
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Rentang Tanggal</label>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="date" id="filter-start-date"
                                                    class="form-control form-control-md" placeholder="Mulai">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" id="filter-end-date"
                                                    class="form-control form-control-md" placeholder="Selesai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-reset-filter" class="btn btn-md btn-outline-danger">
                        <i class="bi bi-eraser me-1"></i>Reset
                    </button>
                </div>

                <!-- Tombol Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <button class="btn btn-primary px-3 d-inline-flex align-items-center gap-2"
                        onclick="openDynamicModal({
                            title: 'Tambah Nama Pelatihan',
                            method: 'POST',
                            icon: 'bi-plus-circle',
                            action: '{{ route('dashboard.pelatihan.nomenklatur.store') }}',
                            fields: [
                                { name: 'kode_namapelatihan', label: 'Kode Pelatihan', type: 'text', required: true},
                                { name: 'nama_pelatihan', label: 'Nama Pelatihan', type: 'text', required: true},
                                {
                                    name: 'jenispelatihan_id', label: 'Jenis Pelatihan', type: 'select', required: true, col: 6,
                                    select2: true,
                                    options: [
                                        { value: '', label: 'Pilih Jenis Pelatihan', disabled: true },
                                        @foreach ($jenispelatihans as $jenis)
                                            { value: '{{ $jenis->id }}', label: '{{ $jenis->jenis_pelatihan }}' }, @endforeach
                                    ]
                                },
                                {
                                    name: 'status', label: 'Status', type: 'select', required: true, col: 6,
                                    options: [
                                        { value: '', label: 'Pilih Status', disabled: true },
                                        { value: 'proses', label: 'Proses' },
                                        { value: 'diterima', label: 'Diterima' },
                                        { value: 'ditolak', label: 'Ditolak' }
                                    ]
                                },
                                { name: 'keterangan', label: 'Keterangan', type: 'textarea', required: false }
                            ]
                        })">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Nama Pelatihan</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.nomenklatur._table', [
                    'namapelatihans' => $namapelatihans,
                ])
            </div>
        </div>

        <div class="card-footer px-5 py-3" id="pagination-wrapper">
            {{ $namapelatihans->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('scripts-pengaturandasar')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @if (session('open_modal') && session('modal_fields'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                openDynamicModal({
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Nama Pelatihan' : 'Tambah Nama Pelatihan' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.nomenklatur.update', old('id', session('data_edit.id') ?? '')) : route('dashboard.pelatihan.nomenklatur.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.nomenklatur.script')
@endsection
