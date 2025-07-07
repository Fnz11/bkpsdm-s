@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Alumni</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('evaluasi.updatealumni', $pelatihan_5_pascadiklatalumni->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $pelatihan_5_pascadiklatalumni->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $pelatihan_5_pascadiklatalumni->nip) }}" required>
        </div>

        <div class="form-group">
            <label for="pangkat_golongan">Pangkat/Golongan</label>
            <input type="text" class="form-control" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan', $pelatihan_5_pascadiklatalumni->pangkat_golongan) }}" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $pelatihan_5_pascadiklatalumni->jabatan) }}" required>
        </div>

        <div class="form-group">
            <label for="unitkerja">Unit Kerja</label>
            <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="{{ old('unitkerja', $pelatihan_5_pascadiklatalumni->unitkerja) }}" required>
        </div>

        <div class="form-group">
            <label for="jenis_pelatihan">Jenis Pelatihan</label>
            <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" value="{{ old('jenis_pelatihan', $pelatihan_5_pascadiklatalumni->jenis_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="nama_pelatihan">Nama Pelatihan</label>
            <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" value="{{ old('nama_pelatihan', $pelatihan_5_pascadiklatalumni->nama_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="penyelenggara_pelatihan">Penyelenggara</label>
            <input type="text" class="form-control" id="penyelenggara_pelatihan" name="penyelenggara_pelatihan" value="{{ old('penyelenggara_pelatihan', $pelatihan_5_pascadiklatalumni->penyelenggara_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="pelaksanaan_pelatihan">Pelaksanaan Pelatihan</label>
            <input type="text" class="form-control" id="pelaksanaan_pelatihan" name="pelaksanaan_pelatihan"
                value="{{ old('pelaksanaan_pelatihan', $pelatihan_5_pascadiklatalumni->pelaksanaan_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="biaya">Biaya</label>
            <input type="text" class="form-control" id="biaya" name="biaya"
                value="{{ old('biaya', $pelatihan_5_pascadiklatalumni->biaya) }}" required>
        </div>

        <div class="form-group">
            <label for="laporan">Laporan</label>
            <input type="text" class="form-control" id="laporan" name="laporan"
                value="{{ old('laporan', $pelatihan_5_pascadiklatalumni->laporan) }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pelatihan">Tanggal Pelatihan</label>
            <input type="date" class="form-control" id="tanggal_pelatihan" name="tanggal_pelatihan" value="{{ old('tanggal_pelatihan', $pelatihan_5_pascadiklatalumni->tanggal_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="selesai_pelatihan">Tanggal Selesai</label>
            <input type="date" class="form-control" id="selesai_pelatihan" name="selesai_pelatihan" value="{{ old('selesai_pelatihan', $pelatihan_5_pascadiklatalumni->selesai_pelatihan) }}" required>
        </div>

        <div class="form-group">
            <label for="hasil_pelatihan">Hasil Pelatihan</label>
            <select class="form-control" id="hasil_pelatihan" name="hasil_pelatihan" required>
                <option value="lulus" {{ $pelatihan_5_pascadiklatalumni->hasil_pelatihan == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="tidak lulus" {{ $pelatihan_5_pascadiklatalumni->hasil_pelatihan == 'tidak lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Status_peserta">Status Peserta</label>
            <select class="form-control" id="Status_peserta" name="Status_peserta" required>
                <option value="Alumni" {{ $pelatihan_5_pascadiklatalumni->Status_peserta == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                <option value="Non Alumni" {{ $pelatihan_5_pascadiklatalumni->Status_peserta == 'Non Alumni' ? 'selected' : '' }}>Non Alumni</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('evaluasi.alumni') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
