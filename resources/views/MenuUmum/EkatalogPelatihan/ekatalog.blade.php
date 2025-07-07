<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelatihan</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- FontAwesome Icons -->
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
            <h2>Daftar Pelatihan</h2>
        </header>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('EkatalogPelatihan.ekatalog') }}">
            <div class="search-bar">
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari Pelatihan"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-custom"><i class="fas fa-search"></i> Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Rumpun Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Nama Pelatihan</th>
                        <th>Detail Pelatihan</th>
                        <th>File Pelatihan</th>
                        <th>Estimasi Biaya</th>
                        <th>Nama Penyelenggara</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($diklats as $index => $diklat)
                        <tr>
                            <td>
                                {{ ($diklats->currentPage() - 1) * $diklats->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $diklat->rumpun_pelatihan }}</td>
                            <td>{{ $diklat->jenis_pelatihan }}</td>
                            <td>{{ $diklat->nama_pelatihan }}</td>
                            <td>{{ $diklat->detail_pelatihan }}</td>
                            <td>
                                @if ($diklat->file_pelatihan)
                                    <a href="{{ asset('storage/' . $diklat->file_pelatihan) }}" class="btn btn-sm btn-custom" target="_blank">
                                        <i class="fa-solid fa-file"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak Ada File</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($diklat->estimasi_biaya, 0, ',', '.') }}</td>
                            <td>{{ $diklat->nama_penyelenggara }}</td>
                            <td>{{ $diklat->no_hp }}</td>
                            <td>
                                <a href="{{ route('EkatalogPelatihan.viewekatalog', ['id' => $diklat->id]) }}" class="btn btn-warning btn-sm" title="Lihat">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $diklats->links('vendor.pagination.bootstrap-4') }}
        </div>

        <footer>
            <p>&copy; 2025 Daftar Pelatihan | All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>
