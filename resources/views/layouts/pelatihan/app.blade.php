<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelatihan') - BKPSDM Surakarta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Familjen+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Select2 CSS Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pelatihan.css') }}">
    
    @yield('additional-css')
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-color);
            line-height: 1.6;
        }

        .content {
            flex: 1;
        }
    </style>
</head>

<body>
    @include('layouts.pelatihan.partials.navbar')

    <!-- MAIN CONTENT -->
    <div class="pt-5 content">
        @yield('content')
    </div>

    @include('layouts.pelatihan.partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('scripts')
</body>

</html>

