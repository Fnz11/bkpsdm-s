@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-3">Daftar Pertanyaan</h2>

    {{-- Form Pencarian --}}
    <a href="{{ route('pertanyaan.create') }}" class="btn btn-primary mb-3">+ Tambah Pertanyaan</a>

    <form action="{{ route('pertanyaan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan pertanyaan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Jenis Pelatihan</th>
                    <th>Kode Kategori Pertanyaan</th>
                    <th>Pertanyaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pertanyaan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_jenispelatihan }}</td>
                        <td>{{ $item->kode_kategoripertanyaan }}</td>
                        <td>{{ $item->pertanyaan }}</td>
                        <td>
    <a href="{{ route('pertanyaan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <form action="{{ route('pertanyaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
    </form>
</td>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $pertanyaan->links() }}
    </div>
</div>
@endsection
