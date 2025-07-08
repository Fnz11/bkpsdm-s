@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Tenggat Upload')

@section('additional-css-pengaturandasar')
@endsection

@section('pengaturandasar-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 p-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                {{-- 🔍 Search & Column toggle --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bi bi-eye me-1"></i>Kolom
                        </button>
                        <ul class="dropdown-menu">
                            @foreach (['no', 'tahun', 'jenis', 'mulai', 'deadline', 'keterangan', 'aksi'] as $col)
                                <li><label class="dropdown-item"><input type="checkbox" class="me-2 toggle-col"
                                            data-target="{{ $col }}" checked> {{ ucfirst($col) }}</label></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- ➕ Add --}}
                <button class="btn btn-primary px-3"
                    onclick="openDynamicModal({
                        title: 'Tambah Tenggat Upload',
                        method: 'POST',
                        icon: 'bi-plus-circle',
                        action: '{{ route('dashboard.pelatihan.tenggat.store') }}',
                        fields: [
                            {
                                name: 'tahun',
                                type: 'select',
                                label: 'Tahun',
                                required: true,
                                placeholder: 'Pilih Tahun',
                                col: 6,
                                select2: true,
                                options: [
                                    @for ($i = now() ->year + 5; $i >= now()->year - 5; $i--)
                                        { value: '{{ $i }}', label: '{{ $i }}' }, @endfor
                                ]
                            },
                            {
                                name: 'jenis_deadline',
                                type: 'select',
                                label: 'Jenis Deadline',
                                required: true,
                                col: 6,
                                options: [
                                    { value: 'laporan_user', label: 'Laporan User' },
                                    { value: 'dokumen_admin', label: 'Dokumen Admin' }
                                ]
                            },
                            {
                                name: 'tanggal_mulai',
                                type: 'date',
                                label: 'Tanggal Mulai',
                                col: 6
                            },
                            {
                                name: 'tanggal_deadline',
                                type: 'date',
                                label: 'Tanggal Deadline',
                                required: true,
                                col: 6
                            },
                            {
                                name: 'tersedia_id',
                                type: 'select',
                                label: 'Pelatihan Tersedia',
                                col: 6,
                                select2: true,
                                options: [
                                    @foreach (\App\Models\Pelatihan2Tersedia::orderBy('nama_pelatihan')->get() as $item)
                                        { value: '{{ $item->id }}', label: '{{ $item->nama_pelatihan }}' }, @endforeach
                                ]
                            },
                            {
                                name: 'pendaftaran_id',
                                type: 'select',
                                label: 'Pendaftaran (Usulan)',
                                col: 6,
                                select2: true,
                                options: [
                                    @foreach (\App\Models\Pelatihan3Pendaftaran::with('usulan')->whereNotNull('usulan_id')->orderBy('id')->get() as $item)
                                    {
                                        value: '{{ $item->id }}',
                                        label: '{{ $item->usulan?->nama_pelatihan ?? $item->kode_pendaftaran }}'
                                    }, @endforeach
                                ]
                            },
                            {
                                name: 'keterangan',
                                type: 'textarea',
                                label: 'Keterangan',
                                placeholder: 'Tambahkan catatan jika diperlukan'
                            }
                        ]
                    })">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Tenggat
                </button>

            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('dashboard.pengaturandasar.tenggatupload._table', [
                    'tenggats' => $tenggats,
                ])
            </div>
        </div>

        <div id="pagination-wrapper" class="card-footer px-5 py-3">
            {{ $tenggats->links('pagination::bootstrap-5') }}
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
                    title: "{{ session('modal_action') === 'edit' ? 'Edit Tenggat' : 'Tambah Tenggat' }}",
                    method: "{{ session('modal_action') === 'edit' ? 'PUT' : 'POST' }}",
                    action: "{{ session('modal_action') === 'edit' ? route('dashboard.pelatihan.tenggat.update', session('data_edit.id')) : route('dashboard.pelatihan.tenggat.store') }}",
                    data: @json(old()),
                    errors: @json($errors->toArray()),
                    fields: @json(session('modal_fields'))
                });
            });
        </script>
    @endif
    @include('dashboard.pengaturandasar.tenggatupload.script')
@endsection
