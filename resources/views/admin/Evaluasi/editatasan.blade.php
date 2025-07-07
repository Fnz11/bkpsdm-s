@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Atasan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('evaluasi.updateatasan', $pelatihan_5_pascadiklatatasan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $pelatihan_5_pascadiklatatasan->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $pelatihan_5_pascadiklatatasan->nip) }}" required>
        </div>

        <div class="form-group">
            <label for="pangkat_golongan">Pangkat/Golongan</label>
            <input type="text" class="form-control" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan', $pelatihan_5_pascadiklatatasan->pangkat_golongan) }}" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $pelatihan_5_pascadiklatatasan->jabatan) }}" required>
        </div>

        <div class="form-group">
            <label for="unitkerja">Unit Kerja</label>
            <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="{{ old('unitkerja', $pelatihan_5_pascadiklatatasan->unitkerja) }}" required>
        </div>

        <div class="form-group">
            <label for="jenis_pelatihan">Jenis Pelatihan</label>
            <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" value="{{ old('jenis_pelatihan', $pelatihan_5_pascadiklatatasan->jenis_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="nama_pelatihan">Nama Pelatihan</label>
            <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" value="{{ old('nama_pelatihan', $pelatihan_5_pascadiklatatasan->nama_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="penyelenggara_pelatihan">Penyelenggara</label>
            <input type="text" class="form-control" id="penyelenggara_pelatihan" name="penyelenggara_pelatihan" value="{{ old('penyelenggara_pelatihan', $pelatihan_5_pascadiklatatasan->penyelenggara_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pelatihan">Tanggal Pelatihan</label>
            <input type="date" class="form-control" id="tanggal_pelatihan" name="tanggal_pelatihan" value="{{ old('tanggal_pelatihan', $pelatihan_5_pascadiklatatasan->tanggal_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="selesai_pelatihan">Tanggal Selesai</label>
            <input type="date" class="form-control" id="selesai_pelatihan" name="selesai_pelatihan" value="{{ old('selesai_pelatihan', $pelatihan_5_pascadiklatatasan->selesai_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="hasil_pelatihan">Hasil Pelatihan</label>
            <select class="form-control" id="hasil_pelatihan" name="hasil_pelatihan" required>
                <option value="lulus" {{ $pelatihan_5_pascadiklatatasan->hasil_pelatihan == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="tidak lulus" {{ $pelatihan_5_pascadiklatatasan->hasil_pelatihan == 'tidak lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Status_peserta">Status Peserta</label>
            <select class="form-control" id="Status_peserta" name="Status_peserta" required>
                <option value="Atasan" {{ $pelatihan_5_pascadiklatatasan->Status_peserta == 'Atasan' ? 'selected' : '' }}>Atasan</option>
                <option value="Non Atasan" {{ $pelatihan_5_pascadiklatatasan->Status_peserta == 'Non Atasan' ? 'selected' : '' }}>Non Atasan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('evaluasi.atasan') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
