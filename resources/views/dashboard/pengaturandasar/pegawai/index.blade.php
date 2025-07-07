@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Referensi Pegawai')

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
                            placeholder="Cari pegawai...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Filter Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'nip', 'nama', 'jenis', 'jabatan', 'golongan', 'sub', 'unit', 'aksi'] as $col)
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
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Jenis ASN</label>
                                        <select name="jenis" id="filter-jenis" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($jenisasns as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_asn }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Unit Kerja</label>
                                        <select name="unit" id="filter-unit" class="form-select form-select-md">
                                            <option value="">Semua</option>
                                            @foreach ($unitkerjas as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unitkerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <!-- Baris Kedua -->
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
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-reset-filter" class="btn btn-md btn-outline-danger">
                        <i class="bi bi-eraser me-1"></i>Reset
                    </button>
                </div>

                <!-- Tombol Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <a href="{{ route('dashboard.pelatihan.pegawai.create') }}"
                        class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Pegawai</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.pegawai._table', [
                    'pegawais' => $pegawais,
                ])
            </div>
        </div>

        <div class="card-footer px-5 py-3" id="pagination-wrapper">
            {{ $pegawais->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('scripts-pengaturandasar')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    @include('dashboard.pengaturandasar.pegawai.script')
@endsection
