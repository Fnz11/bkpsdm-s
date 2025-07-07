@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <!-- Header Table -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Tombol Ganti Tabel -->
                    <div class="btn-group me-3" role="group">
                        <button class="btn btn-light text-primary fw-bold me-2" onclick="changeTable('table1')">Tabel
                            1</button>
                        <button class="btn btn-outline-light fw-bold" onclick="changeTable('table2')">Tabel 2</button>
                    </div>

                    <!-- Search Bar -->
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    </div>

                    <!-- Tombol Cetak dan Export -->
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light text-primary fw-bold" onclick="exportTable()">
                            <i class="bi bi-box-arrow-up me-1"></i> Export
                        </button>
                        <button class="btn btn-light text-primary fw-bold" onclick="printTable()">
                            <i class="bi bi-printer me-1"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel Scrollable -->
            <div class="table-responsive" style="max-height: 66dvh; overflow: auto;">
                <table id="mainTable" class="table table-bordered mb-0">
                    <thead class="bg-primary text-white sticky-top">
                        <tr class="text-center align-middle">
                            <th style="min-width: 25px;">#</th>
                            <th style="min-width: 75px;">Nama</th>
                            <th style="min-width: 75px;">Tempat</th>
                            <th style="min-width: 125px;">Tgl Mulai</th>
                            <th style="min-width: 125px;">Tgl Selesai</th>
                            <th style="min-width: 75px;">Penyelenggara</th>
                            <th style="min-width: 75px;">Deskripsi</th>
                            <th style="min-width: 75px;">Pelaksanaan</th>
                            <th style="min-width: 75px;">Metode</th>
                            <th style="min-width: 75px;">Jenis</th>
                            <th style="min-width: 75px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($pelatihan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_pelatihan }}</td>
                                <td>{{ $item->tempat_pelatihan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                                <td>{{ $item->penyelenggara }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->pelaksanaanPelatihan->pelaksanaan_pelatihan ?? '-' }}</td>
                                <td>{{ $item->metodePelatihan->metode_pelatihan ?? '-' }}</td>
                                <td>{{ $item->jenisPelatihan->jenis_pelatihan ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script -->
    @push('scripts')
        <script>
            function changeTable(name) {
                alert('Mengganti ke: ' + name);
                // Logika ganti tabel bisa disesuaikan di sini
            }

            function printTable() {
                let printContents = document.getElementById('mainTable').outerHTML;
                let originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }

            function exportTable() {
                let table = document.getElementById('mainTable');
                let rows = Array.from(table.rows).map(row =>
                    Array.from(row.cells).map(cell => `"${cell.innerText}"`).join(",")
                ).join("\n");

                let blob = new Blob([rows], {
                    type: 'text/csv'
                });
                let a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'data_export.csv';
                a.click();
            }

            document.getElementById('searchInput').addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection
