@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Pelaksanaan Pelatihan')

@section('additional-css-pengaturandasar')
@endsection

@section('pengaturandasar-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 py-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Filter Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @foreach (['no', 'kode', 'pelaksanaan', 'aksi'] as $col)
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
                </div>

                <!-- Tombol Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <button class="btn btn-primary px-3 d-inline-flex align-items-center gap-2"
                        onclick="openDynamicModal({
                            title: 'Tambah Pelaksanaan Pelatihan',
                            method: 'POST',
                            icon: 'bi-plus-circle',
                            action: '{{ route('dashboard.pelatihan.pelaksanaanpelatihan.store') }}',
                            fields: [
                                {
                                    name: 'kode_pelaksanaanpelatihan',
                                    label: 'Kode Pelaksanaan Pelatihan',
                                    type: 'text',
                                    required: true,
                                    placeholder: 'Contoh: PP00',
                                    col: 12
                                },
                                {
                                    name: 'pelaksanaan_pelatihan',
                                    label: 'Pelaksanaan Pelatihan',
                                    type: 'text',
                                    required: true,
                                    placeholder: 'Contoh: Penyelenggaraan',
                                    col: 12
                                }
                            ]
                        })">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pelaksanaan
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.pelaksanaanpelatihan._table', [
                    'pelaksanaanpelatihans' => $pelaksanaanpelatihans,
                ])
            </div>
        </div>

        
        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $pelaksanaanpelatihans->links('pagination::bootstrap-5') }}
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
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Pelaksanaan Pelatihan' : 'Tambah Pelaksanaan Pelatihan' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.pelaksanaanpelatihan.update', old('id', session('data_edit.id') ?? '')) : route('dashboard.pelatihan.pelaksanaanpelatihan.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.pelaksanaanpelatihan.script')
@endsection
