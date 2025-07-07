@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Jabatan')

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
                            @foreach (['no', 'kategori', 'jabatan', 'aksi'] as $col)
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
                            title: 'Tambah Jabatan',
                            method: 'POST',
                            icon: 'bi-plus-circle',
                            action: '{{ route('dashboard.pelatihan.jabatan.store') }}',
                            fields: [
                                {
                                    name: 'kategorijabatan_id',
                                    label: 'Kategori Jabatan',
                                    type: 'select',
                                    required: true,
                                    col: 12,
                                    select2: true,
                                    placeholder: 'Cari & Pilih Kategori Jabatan',
                                    options: [
                                        @foreach ($kategorijabatans as $kategori)
                                            { value: '{{ $kategori->id }}', label: '{{ $kategori->kategori_jabatan }}' }, @endforeach
                                    ]
                                },
                                {
                                    name: 'jabatan',
                                    label: 'Jabatan',
                                    type: 'text',
                                    required: true,
                                    placeholder: 'Contoh: Kepala Dinas, Sekretaris, dll.',
                                    col: 12
                                }
                            ]
                        })">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Jabatan
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.jabatan._table', [
                    'jabatans' => $jabatans,
                ])
            </div>
        </div>
        
        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $jabatans->links('pagination::bootstrap-5') }}
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
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Jabatan' : 'Tambah Jabatan' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.jabatan.update', old('id', session('data_edit.id') ?? '')) : route('dashboard.pelatihan.jabatan.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.jabatan.script')
@endsection
