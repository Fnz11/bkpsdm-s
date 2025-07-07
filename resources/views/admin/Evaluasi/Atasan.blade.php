@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-3">Daftar Atasan</h2>

        {{-- Form Pencarian --}}
        <form action="{{ route('evaluasi.atasan') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                </div>
                </form>

                {{-- Tabel Data Atasan --}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Pangkat/Golongan</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            @forelse ($pelatihan_5_pascadiklat_atasan as $data)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $data->nip }}
                                    </td>
                                    <td>
                                        {{ $data->nama }}
                                    </td>
                                    <td>
                                        {{ $data->pangkat_golongan }}
                                    </td>
                                    <td>
                                        {{ $data->jabatan }}
                                    </td>
                                    <td>
                                        {{ $data->unit_kerja }}
                                    </td>
                                    <td>
                                        {{ $data->no_hp }}
                                    </td>
                                    <td>
                                        <a href="{{ route('evaluasi.viewatasan', $data->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('evaluasi.editatasan', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('evaluasi.destroyatasan', $data->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method
                                            ('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Data atasan tidak ditemukan.</td>
                                </tr>
                            @endforelse
                            </tbody>
                            </table>
                            </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $pelatihan_5_pascadiklat_atasan->links() }}
                </div>
                </div>
@endsection
