<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alumni</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .navbar {
            background: #007bff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            padding: 25px;
            text-align: center;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            display: block;
            margin: 0 auto;
        }

        .btn-danger {
            background-color: #dc3545;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 15px;
        }

        .content-container {
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 30px;
        }
    </style>
    </head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
        <span class="navbar-brand">Dashboard Alumni</span>
        <a href="{{ route('logout') }}" class="btn btn-danger ms-auto"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
    
    <div class="content-container">
        <div class="card">
            <img src="{{ asset('storage/' . $ref_pegawai->foto) }}" alt="Foto" class="profile-img mb-3">
            <h5 class="fw-bold text-primary">
                {{ $ref_pegawai->nama }}
            </h5>
            <p class="text-muted">
                {{ $ref_pegawai->jabatan }}
            </p>
            <p class="text-muted small">
                {{ $ref_pegawai->unit_kerja }}
            </p>
            <hr>
            <p><strong>NIP:</strong> {{ $ref_pegawai->nip }}
            </p>
            <p><strong>Email:</strong> {{ $ref_pegawai->email }}
            </p>
            <p><strong>No HP:</strong> {{ $ref_pegawai->no_hp }}
            </p>
        </div>
    
        <div class="mt-3">
            <a href="{{ route('evaluasi.formalumni') }}" class="btn btn-primary px-4 py-2">Menuju Evaluasi</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    
    </html>
