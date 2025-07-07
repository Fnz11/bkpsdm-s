@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-3">Tambah Pertanyaan Baru</h2>

    <a href="{{ route('pertanyaan.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Pertanyaan</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pertanyaan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
    <label for="kode_jenispelatihan" class="form-label">Kode Jenis Pelatihan</label>
    <select name="kode_jenispelatihan" class="form-control" required>
        <option value="">-- Pilih Kode Jenis Pelatihan --</option>
        <option value="JP001">JP001 - Diklat Dasar</option>
        <option value="JP002">JP002 - Diklat Fungsional</option>
        <option value="JP003">JP003 - Diklat Struktural</option>
        <option value="JP004">JP004 - Diklat Teknis</option>
    </select>
</div>

        <div class="mb-3">
            <label for="kode_kategoripertanyaan" class="form-label">Kode Kategori Pertanyaan</label>
            <input type="text" name="kode_kategoripertanyaan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <input type="text" name="pertanyaan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
