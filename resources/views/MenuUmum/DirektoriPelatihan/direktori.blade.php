<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Pelatihan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eef2f7;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
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

        footer {
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 0 0 15px 15px;
            margin-top: 30px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
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

        table {
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="text-start mt-4 ms-4">
        <button class="btn btn-secondary" onclick="location.href='{{ route('frontpage.index') }}'">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div class="container">
        <header>
            <h2>Daftar Laporan Pelatihan</h2>
            <button class="btn btn-light" onclick="location.href='{{ route('DirektoriPelatihan.createdirektori') }}'">Tambah Laporan</button>
        </header>

        <form method="GET" action="{{ route('DirektoriPelatihan.direktori') }}">
            <div class="search-bar">
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari Judul Laporan" value="{{ request('search') }}">
                <button type="submit" class="btn btn-custom"><i class="fas fa-search"></i> Cari</button>
                </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul Laporan</th>
                        <th>Nama</th>
                        <th>Unit Kerja</th>
                        <th>Tanggal Mulai</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($directory_2_laporans as $laporan)
                        <tr>
                            <td>
                                {{ ($directory_2_laporans->firstItem() ?? 0) + $loop->iteration - 1 }}
                            </td>
                            <td>
                                {{ $laporan->judul_laporan }}
                            </td>
                            <td>
                                {{ $laporan->nama }}
                            </td>
                            <td>
                                {{ $laporan->unit_kerja }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($laporan->tanggal_mulai)->format('Y-m-d') }}
                            </td>
                            <td>
                                <a href="{{ route('DirektoriPelatihan.viewdirektori', $laporan->id) }}" class="btn btn-sm btn-custom">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $directory_2_laporans->links('vendor.pagination.bootstrap-4') }}
        </div>

        <footer>
            <p>&copy; 2025 Daftar Laporan Pelatihan | All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>
