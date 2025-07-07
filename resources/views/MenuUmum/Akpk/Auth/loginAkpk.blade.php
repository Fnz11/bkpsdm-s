<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akpk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-vh-100">
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
            <!-- Bagian Kiri (Gambar) -->
            <div class="col-md-6 p-0 position-relative">
                <img src="/images/balkot.jpg" alt="Balai Kota Surakarta" class="w-100 h-100 object-fit-cover">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(30, 58, 138, 0.5);">
                </div>
            </div>

            <!-- Bagian Kanan (Form Login) -->
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4 p-md-5 bg-white">
                <!-- Logo -->
                <img src="/images/logoBkpsdm.svg" alt="BKPSDM Logo" class="mb-4" style="width: 120px;">

                <!-- Judul -->
                <h2 class="fw-semibold text-dark mb-2">Sign in</h2>
                <p class="text-muted mb-4">Enter your credentials to sign in</p>

                <!-- Form Login -->
                <form action="{{ route('login.akpk.post') }}" method="POST" class="w-100" style="max-width: 400px;">
                    @csrf

                    <!-- Input NIP -->
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" id="nip" name="nip" class="form-control" required>
                    </div>

                    <!-- Input Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary w-100">
                        Sign in
                    </button>
                </form>

                <!-- Divider dengan teks -->
                <div class="d-flex align-items-center my-4 w-100" style="max-width: 400px;">
                    <hr class="flex-grow-1 border-secondary">
                    <span class="px-3 text-muted">or</span>
                    <hr class="flex-grow-1 border-secondary">
                </div>

                <!-- Tombol Login Admin -->
                <div class="d-flex gap-2 w-100" style="max-width: 400px;">
                    <a href="/admin0" class="btn btn-outline-secondary flex-grow-1">Admin Login</a>
                    <a href="/admin0" class="btn btn-outline-secondary flex-grow-1">Super Admin</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
