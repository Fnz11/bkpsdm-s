<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan Brosur</title>
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
            <h2>Usulan Brosur</h2>
            <button class="btn btn-light" onclick="location.href='{{ route('BrosurPelatihan.createusulan') }}'">Tambah Usulan</button>
        </header>

        <form method="GET" action="{{ route('BrosurPelatihan.usulan') }}">
            <div class="search-bar">
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari Penyelenggara" value="{{ request('search') }}">
                <button type="submit" class="btn btn-custom"><i class="fas fa-search"></i> Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Penyelenggara</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>No. HP</th>
                        <th>Katalog PDF</th>
                        <th>Katalog Excel</th>
                        <th>Tanggal Ajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usulan as $item)
                        <tr>
                            <td>{{ ($usulan->firstItem() ?? 0) + $loop->iteration - 1 }}</td>
                            <td>{{ $item->nama_penyelenggara }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->no_telepon }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>
                                @if ($item->katalog_pdf)
                                    <a href="{{ asset($item->katalog_pdf) }}" class="btn btn-sm btn-custom">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($item->katalog_excel)
                                    <a href="{{ asset($item->katalog_excel) }}" class="btn btn-sm btn-custom">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_katalog_masuk)->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $usulan->links('vendor.pagination.bootstrap-4') }}
        </div>

        <footer>
            <p>&copy; 2025 Usulan Brosur | All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>
