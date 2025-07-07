@extends('layouts.pelatihan.app')

@section('title', 'Pendaftaran Pelatihan - BKPSDM')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 bg-transparent">
            <div class="d-flex flex-column">
                <h4 class="fw-bold mb-1">Pendaftaran Pelatihan</h4>
                <p class="text-muted mb-0">Lengkapi formulir berikut untuk mendaftar pelatihan</p>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pelatihan.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Nama Pelatihan -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Pelatihan</label>
                        <input type="text" class="form-control form-control-solid"
                            value="{{ $pelatihan->nama_pelatihan }}" readonly>
                    </div>
                    <input type="text" name="id_pelatihan" id="id_pelatihan" value="{{ $pelatihan->id }}" hidden>

                    <!-- Biaya Section -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Biaya Akomodasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control form-control-solid" name="biaya_akomodasi"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Biaya Hotel</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control form-control-solid" name="biaya_hotel" placeholder="0"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Biaya Pelatihan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control form-control-solid" name="biaya_pelatihan"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Uang Harian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control form-control-solid" name="uang_harian" placeholder="0"
                                required>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">File Usulan</label>
                        <input type="file" class="form-control form-control-solid" name="file_usulan"
                            accept=".pdf,.doc,.docx" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">File Penawaran</label>
                        <input type="file" class="form-control form-control-solid" name="file_penawaran"
                            accept=".pdf,.doc,.docx" required>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" onclick="window.history.back()">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Simpan Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #5e6278;
        }

        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
            transition: color 0.2s ease;
        }

        .form-control-solid:focus {
            background-color: #eef3f7;
            border-color: #009ef7;
            color: #5e6278;
            box-shadow: none;
        }

        .form-select-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        .form-select-solid:focus {
            background-color: #eef3f7;
            border-color: #009ef7;
            box-shadow: none;
        }

        .input-group-text {
            border: none;
            font-size: 0.875rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.475rem;
        }

        .btn-light {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #7e8299;
        }

        .btn-light:hover {
            background-color: #e4e6ef;
            border-color: #e4e6ef;
            color: #7e8299;
        }
    </style>
@endsection
