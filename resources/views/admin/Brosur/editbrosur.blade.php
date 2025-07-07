@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0 fw-bold">Edit Brosur</h4>
                    </div>

                    <div class="card-body bg-light">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    <form action="{{ route('brosur.update', $brosur->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Penyelenggara</label>
            <input type="text" name="nama_penyelenggara"
                value="{{ old('nama_penyelenggara', $brosur->nama_penyelenggara) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', $brosur->alamat) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Sales</label>
            <input type="text" name="nama_sales" value="{{ old('nama_sales', $brosur->nama_sales) }}" class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $brosur->no_hp) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat" value="{{ old('no_surat', $brosur->no_surat) }}" class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $brosur->tanggal_surat) }}"
                class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Katalog Masuk</label>
            <input type="date" name="tanggal_katalog_masuk"
                value="{{ old('tanggal_katalog_masuk', $brosur->tanggal_katalog_masuk) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Katalog PDF</label>
            <input type="file" name="katalog_pdf" class="form-control">
            @if ($brosur->katalog_pdf)
                <p>File saat ini: <a href="{{ Storage::url($brosur->katalog_pdf) }}" target="_blank">Lihat PDF</a></p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Katalog Excel</label>
            <input type="file" name="katalog_excel" class="form-control">
            @if ($brosur->katalog_excel)
                <p>File saat ini: <a href="{{ Storage::url($brosur->katalog_excel) }}" target="_blank">Lihat Excel</a></p>
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route($brosur->status === 'arsip' ? 'Admin.Brosur.arsip' : 'Admin.Brosur.usulan') }}"
                class="btn btn-secondary">Batal</a>
        </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection