<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Pasca Diklat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin-top: 50px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            padding: 25px;
            margin-bottom: 25px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        h2, h4 {
            text-align: center;
            color: #007bff;
            font-weight: bold;
        }

        label {
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Evaluasi Pasca Diklat</h2>
        <p class="text-center">Silakan isi evaluasi setelah pelatihan.</p>

        <div class="card">
            <h4>Identitas Diri</h4>
            <p><strong>NIP:</strong> {{ $ref_pegawais->nip }}
            </p>
            <p><strong>Nama:</strong> {{ $ref_pegawais->nama }}
            </p>
            <p><strong>Pangkat:</strong> {{ $ref_pegawais->pangkat }}
            </p>
            <p><strong>Golongan:</strong> {{ $ref_pegawais->golongan }}
            </p>
            <p><strong>Jabatan:</strong> {{ $ref_pegawais->jabatan }}
            </p>
            <p><strong>Unit Kerja:</strong> {{ $ref_pegawais->unit_kerja }}
            </p>
        </div>

        <div class="card">
            <h4>Form Evaluasi</h4>@if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluasi.simpanalumni') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
                    <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" required>
                </div>
                <div class="mb-3">
    <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
    <select class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" required>
        <option value="">-- Pilih Jenis Pelatihan --</option>
        <option value="JP001">JP001 - Diklat Dasar</option>
        <option value="JP002">JP002 - Diklat Fungsional</option>
        <option value="JP003">JP003 - Diklat Struktural</option>
        <option value="JP004">JP004 - Diklat Teknis</option>
    </select>
    </div>

                <div class="mb-3">
                    <label for="nip_atasan" class="form-label">NIP Atasan</label>
                    <input type="text" class="form-control" id="nip_atasan" name="nip_atasan" required>
                </div>
                <div class="mb-3">
                    <label for="nama_atasan" class="form-label">Nama Atasan</label>
                    <input type="text" class="form-control" id="nama_atasan" name="nama_atasan" required>
                </div>
                <div class="mb-3">
                    <label for="nip_rekankerja" class="form-label">NIP Rekan Kerja</label>
                    <input type="text" class="form-control" id="nip_rekankerja" name="nip_rekankerja" required>
                </div>
                <div class="mb-3">
                    <label for="nama_rekankerja" class="form-label">Nama Rekan Kerja</label>
                    <input type="text" class="form-control" id="nama_rekankerja" name="nama_rekankerja" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>