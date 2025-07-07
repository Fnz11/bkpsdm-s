@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Informasi Pelatihan')
@section('page-title', 'Informasi Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Informasi Pelatihan</li>
    </ol>
@endsection

@section('additional-css')
    <style>
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

        #filter-area {
            overflow-x: auto;
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
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 py-4 bg-transparent">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 flex-wrap">
                <!-- Kiri: Pencarian & Filter Kolom -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 flex-wrap">
                    <!-- Search -->
                    <div class="position-relative has-clear">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="filter-search" class="form-control form-control-solid ps-10 w-md-250px"
                            placeholder="Cari pelatihan...">
                        <i class="bi bi-x-circle clear-search" id="clear-search"></i>
                    </div>

                    <!-- Dropdown Tampilkan Kolom -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-md dropdown-toggle border border-secondary" type="button" id="columnDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bi bi-eye me-1"></i>Tampilkan Kolom
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="columnDropdown">
                            @php
                                $columns = [
                                    'no' => 'No',
                                    'gambar' => 'Gambar',
                                    'info' => 'Info',
                                    // 'keterangan' => 'Keterangan',
                                    'link' => 'Link',
                                    'aksi' => 'Aksi',
                                ];
                            @endphp
                            @foreach ($columns as $key => $label)
                                <li>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="me-2 toggle-col" data-target="{{ $key }}"
                                            checked>
                                        {{ $label }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Kanan: Tombol Reset & Tambah -->
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                    <a href="{{ route('dashboard.pelatihan.info.create') }}" class="btn btn-primary btn-md">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Info Pelatihan
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    @include('dashboard.pelatihan.info._table', ['pelatihans' => $pelatihans])
                </table>
            </div>

            <!-- Spinner Loading -->
            <div id="loading-spinner" class="text-center py-3 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer px-5 py-3" id="pagination-wrapper">
                {{ $pelatihans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('message'))
        <script>
            showAlertModal("{{ session('message') }}", "{{ session('title') }}");
        </script>
    @endif
    <script>
        let delayTimer;
        let lastQuery = '';
        let currentJenis = '';

        // Handle clear search button
        $('#filter-search').on('input', function() {
            if ($(this).val().length > 0) {
                $('#clear-search').show();
            } else {
                $('#clear-search').hide();
            }
        });

        $('#clear-search').on('click', function() {
            $('#filter-search').val('').trigger('keyup');
            $(this).hide();
        });

        // Update event handler untuk search
        $('#filter-search').on('keyup', function(e) {
            const ignoredKeys = ['Shift', 'Control', 'Alt', 'Meta', 'ArrowLeft', 'ArrowRight', 'ArrowUp',
                'ArrowDown'
            ];
            if (ignoredKeys.includes(e.key)) {
                return;
            }

            clearTimeout(delayTimer);
            let query = $(this).val().trim();

            // Toggle visibility clear button
            $('#clear-search').toggle(query.length > 0);

            delayTimer = setTimeout(function() {
                if (query !== lastQuery) {
                    lastQuery = query;
                    fetchData();
                }
            }, 300);
        });

        // Pagination AJAX
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchData(page);
        });

        // Toggle Column
        $('.toggle-col').on('change', function() {
            applyColumnToggles();
        });

        // Fetch Data
        function fetchData(page = 1) {
            $('#pelatihan-info-table').addClass('d-none');
            $('#loading-spinner').removeClass('d-none');
            $('.pagination a').addClass('disabled');

            $.ajax({
                url: "{{ route('dashboard.pelatihan.info') }}",
                type: "GET",
                data: {
                    page: page,
                    search: $('#filter-search').val(),
                },
                success: function(response) {
                    $('#pelatihan-info-table').html($(response).find('#pelatihan-info-table').html());
                    $('#pagination-wrapper').html($(response).find('#pagination-wrapper').html());
                    applyColumnToggles();
                },
                complete: function() {
                    $('#pelatihan-info-table').removeClass('d-none');
                    $('#loading-spinner').addClass('d-none');
                    $('.pagination a').removeClass('disabled');
                }
            });
        }

        function applyColumnToggles() {
            $('.toggle-col').each(function() {
                const target = $(this).data('target');
                const selector = '.col-' + target;

                if (!$(this).is(':checked')) {
                    $(selector).hide();
                } else {
                    $(selector).show();
                }
            });
        }
    </script>
@endsection
