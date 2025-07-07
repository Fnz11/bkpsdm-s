@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-3">Daftar Alumni</h2>

        {{-- Form Pencarian --}}
        <form action="{{ route('evaluasi.alumni') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama pelatihan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        {{-- Tabel Data Alumni --}}
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Pangkat</th>
                        <th>Golongan</th>
                        <th>Jabatan</th>
                        <th>Unit Kerja</th>
                        <th>Jenis Pelatihan</th>
                        <th>Nama Pelatihan</th>
                        <th>Tanggal Pelatihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelatihan_5_pascadiklat_alumni as $alumni)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $alumni->nip }}</td>
                            <td>{{ $alumni->nama }}</td>
                            <td>{{ $alumni->pangkat }}</td>
                            <td>{{ $alumni->golongan }}</td>
                            <td>{{ $alumni->jabatan }}</td>
                            <td>{{ $alumni->unit_kerja }}</td>
                            <td>{{ $alumni->jenis_pelatihan }}</td>
                            <td>{{ $alumni->nama_pelatihan }}</td>
                            <td>{{ date('d-m-Y', strtotime($alumni->tanggal_pelatihan)) }}</td>
                            <td>
                                <a href="{{ route('evaluasi.viewalumni', $alumni->alumni_id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('evaluasi.editalumni', $alumni->alumni_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('evaluasi.destroyalumni', $alumni->alumni_id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">Data alumni tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $pelatihan_5_pascadiklat_alumni->links() }}
        </div>
    </div>
@endsection
