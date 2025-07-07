@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Usulkan Nama Pelatihan')
@section('page-title', 'Usulkan Nama Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.nomenklatur') }}">Nomenklatur</a></li>
        <li class="breadcrumb-item active">Usul Nomenklatur</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Usulan Nama Pelatihan</h5>
        </div>
        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-{{ session('message.type') ?? 'success' }} alert-dismissible fade show">
                    <strong>{{ session('message.title') ?? 'Success' }}!</strong> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> Terdapat kesalahan dalam pengisian form:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('dashboard.pelatihan.nomenklaturadmin.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenispelatihan_id" class="form-label">Jenis Pelatihan <span
                                    class="text-danger">*</span></label>
                            <select name="jenispelatihan_id" id="jenispelatihan_id"
                                class="form-select @error('jenispelatihan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Pelatihan --</option>
                                @foreach ($jenispelatihans as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ old('jenispelatihan_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenispelatihan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nama_pelatihan" class="form-label">Nama Pelatihan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelatihan" id="nama_pelatihan"
                                class="form-control @error('nama_pelatihan') is-invalid @enderror"
                                value="{{ old('nama_pelatihan') }}" required>
                            @error('nama_pelatihan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="nip" value="{{ auth()->user()->nip }}">
                <input type="hidden" name="status" value="proses">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.pelatihan.nomenklaturadmin') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-1"></i> Usulkan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        .form-label {
            font-weight: 500;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Jika ada error, scroll ke form
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const firstErrorField = document.querySelector('.is-invalid');
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstErrorField.focus();
                }
            });
        @endif
    </script>
@endsection
