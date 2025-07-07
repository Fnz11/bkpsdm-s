@extends('layouts.pelatihan.pelatihan-dashboard')
    
@section('tab')
    <div class="d-flex flex-wrap gap-2 mb-3">
        @php
            $tabs = [
                ['route' => 'dashboard.pelatihan.jenispelatihan', 'icon' => 'bi-tags', 'label' => 'Jenis Pelatihan'],
                ['route' => 'dashboard.pelatihan.metodepelatihan', 'icon' => 'bi-gear', 'label' => 'Metode Pelatihan'],
                [
                    'route' => 'dashboard.pelatihan.pelaksanaanpelatihan',
                    'icon' => 'bi-calendar-event',
                    'label' => 'Pelaksanaan Pelatihan',
                ],
                ['route' => 'dashboard.pelatihan.nomenklatur', 'icon' => 'bi-list-ul', 'label' => 'Nama Pelatihan'],
                ['route' => 'dashboard.pelatihan.jenisasn', 'icon' => 'bi-person-vcard', 'label' => 'Jenis ASN'],
                ['route' => 'dashboard.pelatihan.golongan', 'icon' => 'bi-person-badge', 'label' => 'Golongan'],
                [
                    'route' => 'dashboard.pelatihan.kategorijabatan',
                    'icon' => 'bi-list-check',
                    'label' => 'Kategori Jabatan',
                ],
                ['route' => 'dashboard.pelatihan.jabatan', 'icon' => 'bi-briefcase', 'label' => 'Jabatan'],
                ['route' => 'dashboard.pelatihan.unitkerja', 'icon' => 'bi-building', 'label' => 'Unit Kerja'],
                ['route' => 'dashboard.pelatihan.subunitkerja', 'icon' => 'bi-diagram-3', 'label' => 'Sub Unit Kerja'],
                ['route' => 'dashboard.pelatihan.pegawai', 'icon' => 'bi-people', 'label' => 'Referensi Pegawai'],
                ['route' => 'dashboard.pelatihan.tenggat', 'icon' => 'bi-clock-history', 'label' => 'Tenggat Upload'],
            ];
        @endphp

        @foreach ($tabs as $tab)
            <a href="{{ request()->routeIs($tab['route'] . '*') ? '#' : route($tab['route']) }}"
                class="btn btn-outline-secondary d-flex align-items-center gap-1 px-3 py-2 fw-semibold shadow-sm transition-all
                    {{ request()->routeIs($tab['route'] . '*') ? 'active text-white bg-secondary' : '' }}">
                <i class="bi {{ $tab['icon'] }}"></i> {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Form Modal Dinamis (Modern Style) -->
    <x-form-modal />
@endsection

@section('additional-css')
    <style>
        .required-label::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

        .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            display: none;
        }

        .clear-search:hover {
            color: #495057;
        }

        .has-clear .form-control {
            padding-right: 2.5rem !important;
        }

        .w-md-250px {
            width: 250px !important;
        }

        .ps-10 {
            padding-left: 2.75rem !important;
        }

        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        .form-control-solid:focus {
            background-color: #eef3f7;
            border-color: #eef3f7;
        }

        .badge-success {
            background-color: #50cd89;
            color: #fff;
        }

        .badge-danger {
            background-color: #f1416c;
            color: #fff;
        }

        .badge-info {
            background-color: #7239ea;
            color: #fff;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
        }

        .dropdown-menu label {
            cursor: pointer;
            width: 100%;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .w-md-250px {
                width: 100% !important;
            }
        }
    </style>
    @yield('additional-css-pengaturandasar')
@endsection

@section('content')
    @yield('pengaturandasar-content')
@endsection

@section('scripts')
    @yield('scripts-pengaturandasar')
    @include('components.scripts.form-modal')
@endsection
