<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelatihan') - BKPSDM Surakarta</title>

    <!-- CSS Dependencies -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pelatihan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-bootstrap.min.css') }}">
    @yield('additional-css')

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* .layout-wrapper {
            display: flex;
            min-height: 100vh;
        } */

        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            padding: 20px 10px 20px 30px;
            width: calc(100% - 280px);
            transition: margin-left 0.3s ease;
        }

        .content-wrapper.expanded {
            margin-left: 60px;
        }

        .content-header {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
        }

        .content-header .container-fluid {
            padding: 0;
        }

        .content-header .row {
            align-items: center;
        }

        .content-header h4 {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            font-size: 1.5rem;
        }

        .content-body {
            background: #fff;
            /* padding: 25px; */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .content-body .container-fluid {
            padding: 0;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #7f8c8d;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #95a5a6;
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
            margin-top: 15px;
        }

        @media (max-width: 992px) {

            .content-header,
            .content-body {
                padding: 15px;
            }

            .content-header h4 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .content-wrapper {
                margin-left: 60px;
            }

            .header {
                left: 60px;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .content-header .col-auto {
                margin-top: 10px;
            }
        }

        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.5rem + 2px);
            font-size: 1rem;
            line-height: 1.5;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 1rem;
            top: 10%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            z-index: 10;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem;
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 70px 10px 10px 10px;
            }

            .content-header,
            .content-body {
                padding: 15px 10px;
                border-radius: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <x-sidebar />

        {{-- <div class="header" id="mainHeader"> --}}
        <x-header />
        {{-- </div> --}}

        <div class="content-wrapper" id="mainContent">
            @if (View::hasSection('page-title') || View::hasSection('breadcrumb') || View::hasSection('tab'))
                <div class="content-header">
                    <div class="container-fluid">
                        @if (View::hasSection('page-title') || View::hasSection('breadcrumb'))
                            <div class="row align-items-center">
                                @hasSection('page-title')
                                    <div class="col">
                                        <h4 class="fw-bold mb-0">@yield('page-title')</h4>
                                    </div>
                                @endif

                                @hasSection('breadcrumb')
                                    <div class="col-auto">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0">
                                                @yield('breadcrumb')
                                            </ol>
                                        </nav>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @hasSection('tab')
                            <div class="row align-items-center">
                                @yield('tab')
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="content-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Global Alert Modal -->
    <x-alert-modal />
    @include('components.scripts.alert-modal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content-wrapper');
            const header = document.querySelector('.header');
            const toggleBtn = document.querySelector('#sidebarToggle');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('closed');
                    content.classList.toggle('expanded');
                    header.classList.toggle('expanded');
                });
            }

            function handleResize() {
                if (window.innerWidth < 768) {
                    sidebar?.classList.add('closed');
                    content?.classList.add('expanded');
                    header?.classList.add('expanded');
                } else {
                    sidebar?.classList.remove('closed');
                    content?.classList.remove('expanded');
                    header?.classList.remove('expanded');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize();
        });
    </script>

    @yield('scripts')
</body>

</html>
