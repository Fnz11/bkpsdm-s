@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Arsip Brosur</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('Admin.Brosur.arsip') }}" class="row g-3 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari penyelenggara...">
            </div>
            <div class="col-md-4">
                <select name="tahun" class="form-select">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama Penyelenggara</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Katalog PDF</th>
                        <th>Katalog Excel</th>
                        <th>Tanggal Ajuan</th>
                        <th>Status Ajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brosur_2_masuks as $item)
                        <tr>
                            <td>
                                {{ ($brosur_2_masuks->firstItem() ?? 0) + $loop->iteration - 1 }}
                            </td>
                            <td>
                                {{ $item->nama_penyelenggara }}
                            </td>
                            <td>
                                {{ $item->alamat }}
                            </td>
                            <td>
                                {{ $item->no_hp }}
                            </td>
                            <td>
                                @if ($item->katalog_pdf)
                                    <a href="{{ asset($item->katalog_pdf) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fa fa-file-pdf"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->katalog_excel)
                                    <a href="{{ asset($item->katalog_excel) }}" class="btn btn-sm btn-success" target="_blank">
                                        <i class="fa fa-file-excel"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_katalog_masuk)->format('Y-m-d') }}
                            </td>
                            <td>
                                <span class="badge {{ $item->status == 'Disetujui' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('Admin.Brosur.editusulan', $item->getKey()) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('brosur.deleteusulan', $item->id) }}" method="POST"
    onsubmit="return confirm('Yakin ingin menghapus?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fa fa-trash"></i> Hapus
    </button>
</form>


                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $brosur_2_masuks->links() }}
        </div>
    </div>
@endsection