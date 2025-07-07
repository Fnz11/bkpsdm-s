<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKPSDM Surakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 100px;
            /* Add padding to account for fixed header */
        }

        main {
            flex: 1;
        }

        .nav-link {
            color: black;
            margin: 0 20px;
        }

        .nav-link:hover {
            color: #1B6AE0;
        }

        .login-btn {
            border: 2px solid #1B6AE0;
            padding: 6px 48px;
            border-radius: 8px;
            color: #1B6AE0;
            text-decoration: none;
            font-weight: 500;
        }

        .login-btn:hover {
            background-color: #1B6AE0;
            color: white;
        }

        footer {
            background: linear-gradient(135deg, #1B6AE0 1%, #1552AD 48%, #0F3A7A 86%);
            color: white;
            padding: 40px 0;
        }

        .footer-logo img {
            height: 60px;
        }

        .footer-social i {
            margin-right: 15px;
            cursor: pointer;
            font-size: 18px;
        }

        .footer-social i:hover {
            color: #ffcc00;
        }

        .footer-links a {
            text-decoration: none;
            color: white;
            font-weight: normal;
            display: block;
            margin-bottom: 8px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer p {
            font-size: 14px;
        }

        iframe {
            width: 100%;
            max-width: 569px;
            height: 326px;
            border: 0;
            border-radius: 8px;
        }

        /* Responsive Header */
        @media (max-width: 991px) {
            .navbar-toggler {
                border: none;
                outline: none;
            }

            /* Center dropdown menus on mobile/tablet */
            .dropdown-menu {
                text-align: center;
            }

            .dropdown-item {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="shadow-sm p-3 bg-white fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/homepage-akpk">
                    <img src="/images/logoBkpsdm.svg" alt="BKPSDM Logo" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto text-center">
                        <li class="nav-item"><a class="nav-link active" href="/homepage-akpk">Beranda</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                @guest onclick="showLoginAlert(event);" @endguest>
                                Assessment
                            </a>
                            @auth
                                <ul class="dropdown-menu text-center">
                                    <li><a class="dropdown-item" href="/selfAssessment">Self Assessment</a></li>
                                    <li><a class="dropdown-item" href="/assessmentBawahan">Assessment Bawahan</a></li>
                                    <li><a class="dropdown-item" href="/hasilSelfAssessment">Hasil Self Assessment</a></li>
                                    <li><a class="dropdown-item" href="/hasilAssessmentBawahan">Hasil Assessment Bawahan</a>
                                    </li>
                                </ul>
                            @endauth
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                @guest onclick="showLoginAlert(event);" @endguest>
                                Usulan
                            </a>
                            @auth
                                <ul class="dropdown-menu text-center">
                                    <li><a class="dropdown-item" href="/usulan">Usulan Pelatihan</a></li>
                                    <li><a class="dropdown-item" href="/nomenklatur">Nomenklatur</a></li>
                                    <li><a class="dropdown-item" href="/solowasis">Usulan Solowasis</a></li>
                                </ul>
                            @endauth
                        </li>
                        @guest
                            <li class="nav-item mt-2">
                                <a href="{{ route('login.akpk') }}" class="nav-link login-btn d-lg-none">Login</a>
                            </li>
                        @endguest
                    </ul>
                </div>
                @auth
                    <div class="d-none d-lg-block position-absolute top-0 end-0 pe-3 pt-3">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle mt-2"
                                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/images/avatarUser.svg" alt="Profile" height="30" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="/profilAKPK">Profil</a></li>
                                <li><a class="dropdown-item" href="#">Setting</a></li>
                                <li>
                                    <form action="{{ route('logout.akpk') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login.akpk') }}" class="login-btn d-none d-lg-block">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container d-flex flex-wrap justify-content-between align-items-start">
            <div class="footer-logo col-md-4 mb-4">
                <img src="/images/logoBkpsdm.svg" alt="BKPSDM Logo">
                <p class="mt-2">Lörem ipsum od ohet dilogi. Bell trabel, samuligt, ohöbel utom diska. Jinesade bel när
                    feras redorade i belogi.</p>
                <div class="footer-social">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-linkedin"></i>
                    <i class="bi bi-instagram"></i>
                </div>
            </div>
            <div class="col-md-3 mb-4">

                <h5>Halaman</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Penilaian</a></li>
                    <li><a href="#">Usulan</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Peta Lokasi</h5>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.0467781690963!2d110.82864149999999!3d-7.5698794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16604244913d%3A0xb23896628cd69569!2sBKPSDM%20Kota%20Surakarta!5e0!3m2!1sid!2sid!4v1744260308106!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoginAlert(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Akses Ditolak',
                text: 'Silakan login terlebih dahulu untuk mengakses menu ini.',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>

</html>
