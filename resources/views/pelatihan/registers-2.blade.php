@extends('layouts.pelatihan.app')

@section('title', 'Pendaftaran Pelatihan - BKPSDM')

@section('content')
    <div class="container mt-5">
        <div class="mx-auto py-4 px-5 card border-0 shadow-sm" style="max-width: 720px;">
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
                        <!-- NIP -->
                        <input type="hidden" name="nip" value="{{ Auth::user()->nip }}">

                        <!-- Nama Pelatihan -->
                        <div class="col-12 position-relative">
                            <label class="form-label fw-bold">Nama Pelatihan</label>
                            <select name="id_pelatihan" class="form-select form-select-solid select2" required>
                                <option value=""></option>
                                @foreach ($namaPelatihan as $pelatihan)
                                    <option value="{{ $pelatihan->id }}">{{ $pelatihan->nama_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- File Usulan -->
                        <div class="col-12">
                            <label class="form-label fw-bold">File Usulan</label>
                            <input type="file" class="form-control form-control-solid" name="file_usulan"
                                accept=".pdf,.doc,.docx" required>
                        </div>

                        <!-- Tombol Aksi -->
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
    </div>
@endsection

@section('additional-css')
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.5rem + 2px);
            /* padding: 0.375rem 0.75rem; */
            font-size: 1rem;
            line-height: 1.5;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 1rem;
            top: 10%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            z-index: 10;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem;
        }

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

@section('scripts')
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Nama Pelatihan...", // akan tampil sebagai placeholder
            allowClear: true,
            width: '100%'
        });


        // document.addEventListener('DOMContentLoaded', function() {
        //     const input = document.getElementById('nama_pelatihan_search');
        //     const list = document.getElementById('namaPelatihanList');
        //     const hiddenInput = document.getElementById('pelatihan_id');

        //     input.addEventListener('input', function() {
        //         const keyword = input.value;

        //         if (keyword.length < 2) {
        //             list.style.display = 'none';
        //             return;
        //         }

        //         fetch(`/api/search-pelatihan-register?keyword=${keyword}`)
        //             .then(res => res.json())
        //             .then(data => {
        //                 list.innerHTML = '';

        //                 if (data.length === 0) {
        //                     list.style.display = 'none';
        //                     return;
        //                 }

        //                 data.forEach(item => {
        //                     const option = document.createElement('button');
        //                     option.type = 'button';
        //                     option.className = 'list-group-item list-group-item-action';
        //                     option.textContent = item.nama_pelatihan;
        //                     option.dataset.id = item.id;

        //                     option.addEventListener('click', function() {
        //                         input.value = item.nama_pelatihan;
        //                         hiddenInput.value = item.id;
        //                         list.style.display = 'none';
        //                     });

        //                     list.appendChild(option);
        //                 });

        //                 list.style.display = 'block';
        //             });
        //     });

        //     // Sembunyikan saat klik di luar
        //     document.addEventListener('click', function(e) {
        //         if (!input.contains(e.target) && !list.contains(e.target)) {
        //             list.style.display = 'none';
        //         }
        //     });
        // });
    </script>
@endsection
