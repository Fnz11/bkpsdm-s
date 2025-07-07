@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Golongan')

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
                            @foreach (['no', 'kode', 'jenis', 'golongan', 'pangkat', 'pangkat-golongan', 'aksi'] as $col)
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
                            title: 'Tambah Golongan',
                            method: 'POST',
                            icon: 'bi-plus-circle',
                            action: '{{ route('dashboard.pelatihan.golongan.store') }}',
                            fields: [
                                {
                                    name: 'kode_golongan',
                                    label: 'Kode Golongan',
                                    type: 'text',
                                    required: true,
                                    col: 6,
                                    placeholder: 'Contoh: PNS0XX'
                                },
                                {
                                    name: 'jenisasn_id',
                                    label: 'Jenis ASN',
                                    type: 'select',
                                    required: true,
                                    select2: true,
                                    col: 6,
                                    placeholder: 'Cari & Pilih Jenis ASN',
                                    options: [
                                        @foreach ($jenisasns as $asn)
                                            { value: '{{ $asn->id }}', label: '{{ $asn->jenis_asn }}' }, @endforeach
                                    ]
                                },
                                {
                                    name: 'golongan',
                                    label: 'Golongan',
                                    type: 'text',
                                    required: true,
                                    col: 6,
                                    placeholder: 'Contoh: III/a'
                                },
                                {
                                    name: 'pangkat',
                                    label: 'Pangkat',
                                    type: 'text',
                                    required: true,
                                    col: 6,
                                    placeholder: 'Contoh: Penata Muda'
                                },
                                {
                                    name: 'pangkat_golongan',
                                    label: 'Pangkat Golongan',
                                    type: 'text',
                                    required: true,
                                    col: 12,
                                    placeholder: 'Contoh: Penata Muda (III/a)'
                                }
                            ]
                        })">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Golongan
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.golongan._table', [
                    'golongans' => $golongans,
                ])
            </div>
        </div>
        
        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $golongans->links('pagination::bootstrap-5') }}
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
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Golongan' : 'Tambah Golongan' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.golongan.update', old('id', session('data_edit.id') ?? '')) : route('dashboard.pelatihan.golongan.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.golongan.script')
@endsection
