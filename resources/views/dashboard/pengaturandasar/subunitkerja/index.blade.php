@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Sub Unit Kerja')

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
                            @foreach (['no', 'unitkerja', 'subunit', 'aksi'] as $col)
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
                            title: 'Tambah Sub Unit Kerja',
                            method: 'POST',
                            icon: 'bi-plus-circle',
                            action: '{{ route('dashboard.pelatihan.subunitkerja.store') }}',
                            fields: [
                                {
                                    name: 'unitkerja_id',
                                    label: 'Unit Kerja',
                                    type: 'select',
                                    required: true,
                                    select2: true,
                                    placeholder: 'Cari & Pilih Sub Unit Kerja',
                                    col: 12,
                                    options: [
                                        @foreach ($unitkerjas as $unit)
                                            { value: '{{ $unit->id }}', label: '{{ $unit->unitkerja }}' }, @endforeach
                                    ]
                                },
                                {
                                    name: 'sub_unitkerja',
                                    label: 'Sub Unit Kerja',
                                    type: 'text',
                                    required: true,
                                    placeholder: 'Contoh: Dinas Kesehatan',
                                    col: 6
                                },
                                {
                                    name: 'singkatan',
                                    label: 'Singkatan',
                                    type: 'text',
                                    required: true,
                                    placeholder: 'Contoh: Dinkes',
                                    col: 6
                                }
                            ]
                        })">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Sub Unit Kerja
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.subunitkerja._table', [
                    'subunitkerjas' => $subunitkerjas,
                ])
            </div>
        </div>

        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $subunitkerjas->links('pagination::bootstrap-5') }}
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
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Sub Unit Kerja' : 'Tambah Sub Unit Kerja' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.subunitkerja.update', old('id', session('data_edit.id') ?? '')) : route('dashboard.pelatihan.subunitkerja.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.subunitkerja.script')
@endsection
