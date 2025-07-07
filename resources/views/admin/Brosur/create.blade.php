@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0 fw-bold">Tambah Usulan Brosur</h4>
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

                        <form action="{{ route('brosur.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="source" value="{{ request('source', 'usulan') }}">

                            <div class="mb-3">
                                <label for="nama_penyelenggara" class="form-label">Nama Penyelenggara</label>
                                <input type="text" name="nama_penyelenggara" class="form-control" value="{{ old('nama_penyelenggara') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_sales" class="form-label">Nama Sales</label>
                                <input type="text" name="nama_sales" class="form-control" value="{{ old('nama_sales') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_surat" class="form-label">No Surat</label>
                                <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="brosur_pdf" class="form-label">Upload PDF (Opsional)</label>
                                <input type="file" name="brosur_pdf" class="form-control" accept=".pdf">
                            </div>

                            <div class="mb-3">
                                <label for="brosur_excel" class="form-label">Upload Excel (Opsional)</label>
                                <input type="file" name="brosur_excel" class="form-control" accept=".xls,.xlsx">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach($statusList as $status)
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ request('source', 'usulan') == 'arsip' ? route('Admin.Brosur.arsip') : route('Admin.Brosur.usulan') }}"
                                    class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection