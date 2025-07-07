<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Direktori Pelatihan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eef2f7;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 15px 30px;
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .btn-custom {
            background: #007bff;
            color: white;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #004999;
            transform: scale(1.05);
        }

        .form-label {
            font-weight: 600;
        }

        .alert {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<div class="text-start mt-4 ms-4">
    <button class="btn btn-secondary" onclick="location.href='{{ route('DirektoriPelatihan.direktori') }}'">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

    <div class="container">
        <header>
            <h2>Input Direktori Pelatihan</h2>
        </header>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer || result.isConfirmed) {
                        window.location.href = "{{ route('DirektoriPelatihan.direktori') }}";
                    }
                });
            </script>
            @php session()->forget('success'); @endphp
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                </div>
        @endif

        <form action="{{ route('DirektoriPelatihan.storedirektori') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Golongan/Ruang</label>
                <input type="text" class="form-control" name="golongan_ruang" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Unit Kerja</label>
                <input type="text" class="form-control" name="unit_kerja" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pelatihan</label>
                <input type="text" class="form-control" name="nama_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pelaksanaan Pelatihan</label>
                <input type="text" class="form-control" name="pelaksanaan_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Mulai Pelatihan</label>
                <input type="date" class="form-control" name="tanggal_mulai" required>
            </div>

<div class="mb-3">
    <label class="form-label">Tanggal Selesai Pelatihan</label>
    <input type="date" class="form-control" name="tanggal_selesai" required>
</div>


            <div class="mb-3">
                <label class="form-label">Jenis Pelatihan</label>
                <input type="text" class="form-control" name="jenis_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Metode Pelatihan</label>
                <input type="text" class="form-control" name="metode_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rumpun Pelatihan</label>
                <input type="text" class="form-control" name="rumpun_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penyelenggara Pelatihan</label>
                <input type="text" class="form-control" name="penyelenggara_pelatihan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sertifikat</label>
                <input type="file" class="form-control" name="sertifikat" accept=".pdf,.jpg,.png">
            </div>

            <div class="mb-3">
                <label class="form-label">Status Peserta</label>
                <select class="form-control" name="Status_peserta" required>
                    <option value="Alumni">Alumni</option>
                    <option value="Non Alumni">Non Alumni</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" name="judul_laporan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Abstrak Laporan</label>
                <textarea class="form-control" name="abstrak_laporan" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Link Laporan</label>
                <input type="url" class="form-control" name="link_laporan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="2"></textarea>
            </div>
<div class="d-flex justify-content-between">
    <a href="{{ route('DirektoriPelatihan.direktori') }}" class="btn btn-danger">
        <i class="fa-solid fa-xmark"></i> Cancel
    </a>
    <button type="submit" class="btn btn-custom">
        <i class="fa-solid fa-paper-plane"></i> Submit
    </button>
            </div>
        </form>
    </div>

</body>

</html>
