@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-3">Edit Pertanyaan</h2>

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

    <form action="{{ route('pertanyaan.update', $pertanyaan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
    <label for="kode_jenispelatihan" class="form-label">Kode Jenis Pelatihan</label>
    <select name="kode_jenispelatihan" class="form-control" required>
        <option value="">-- Pilih Kode Jenis Pelatihan --</option>
        <option value="JP001" {{ $pertanyaan->kode_jenispelatihan == 'JP001' ? 'selected' : '' }}>JP001 - Diklat Dasar</option>
        <option value="JP002" {{ $pertanyaan->kode_jenispelatihan == 'JP002' ? 'selected' : '' }}>JP002 - Diklat Fungsional</option>
        <option value="JP003" {{ $pertanyaan->kode_jenispelatihan == 'JP003' ? 'selected' : '' }}>JP003 - Diklat Struktural</option>
        <option value="JP004" {{ $pertanyaan->kode_jenispelatihan == 'JP004' ? 'selected' : '' }}>JP004 - Diklat Teknis</option>
    </select>
</div>

        <div class="mb-3">
            <label for="kode_kategoripertanyaan" class="form-label">Kode Kategori Pertanyaan</label>
            <input type="text" name="kode_kategoripertanyaan" class="form-control" value="{{ $pertanyaan->kode_kategoripertanyaan }}" required>
        </div>
        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <input type="text" name="pertanyaan" class="form-control" value="{{ $pertanyaan->pertanyaan }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
