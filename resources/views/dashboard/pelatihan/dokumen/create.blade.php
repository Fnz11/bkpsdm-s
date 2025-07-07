@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Tambah Dokumen Pelatihan')
@section('page-title', 'Tambah Dokumen Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.dokumen') }}">Dokumen</a></li>
        <li class="breadcrumb-item active">Tambah Dokumen</li>
    </ol>
@endsection

@section('additional-css')
    <style>
        #checkbox-list label {
            cursor: pointer;
        }

        .checkbox-item {
            transition: background-color 0.2s;
            /* margin-bottom: 8px; */
        }

        .checkbox-item:hover {
            background-color: #f1f1f1;
        }

        .checkbox-item input[type="checkbox"] {
            margin-top: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('dashboard.pelatihan.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="nama_dokumen">Nama Dokumen</label>
                    <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="file_path">Unggah File</label>
                    <input type="file" name="file_path" id="file_path" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="search-box">Cari dan Pilih Pendaftaran</label>
                    <input type="text" id="search-box" placeholder="Cari pendaftaran..." class="form-control mb-2">

                    {{-- Checkbox Pilih Semua --}}
                    <div class="form-check mb-2">
                        <input type="checkbox" id="select-all" class="form-check-input">
                        <label for="select-all" class="form-check-label">Pilih Semua</label>
                    </div>

                    <div id="checkbox-list" class="border p-3 rounded overflow-auto" style="max-height: 300px;">
                        @foreach ($pendaftarans as $pendaftaran)
                            @php
                                $pelatihan = $pendaftaran->tersedia ?? $pendaftaran->usulan;
                                $namaPelatihan = $pelatihan->nama_pelatihan ?? '-';
                                $namaUser = $pendaftaran->user->refPegawai->name ?? '-';
                                $kode = $pendaftaran->kode_pendaftaran ?? '-';
                            @endphp
                            <div class="checkbox-item px-2 py-2 rounded"
                                data-nama="{{ strtolower($kode) }} {{ strtolower($namaUser) }} {{ strtolower($namaPelatihan) }}">
                                <label class="d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input me-2" name="pendaftaran_ids[]"
                                        value="{{ $pendaftaran->id }}">
                                    <span>
                                        {{ $kode }} - {{ $namaUser }} - {{ $namaPelatihan }}
                                        <span class="badge {{ $pendaftaran->tersedia ? 'bg-warning' : 'bg-success' }}">
                                            {{ $pendaftaran->tersedia ? 'Tersedia' : 'Usulan' }}
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div id="selected-count" class="mt-2 text-muted">
                        0 pendaftaran dipilih
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control">
                </div>

                <input type="hidden" name="admin_nip" value="{{ auth()->user()->nip }}">

                <div class="d-flex justify-content-between">
                    <a class="btn btn-outline-secondary" href="{{ route('dashboard.pelatihan.dokumen') }}"><i class="bi bi-x-circle me-1"></i>Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Kirim
                        Dokumen</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('search-box');
            const checkboxItems = document.querySelectorAll('.checkbox-item');
            const selectAllCheckbox = document.getElementById('select-all');
            const selectedCountEl = document.getElementById('selected-count');

            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.checkbox-item input[type="checkbox"]:checked')
                    .length;
                selectedCountEl.textContent = `${checkedCount} pendaftaran dipilih`;
            }

            // Filter pencarian
            searchBox.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                checkboxItems.forEach(item => {
                    const text = item.getAttribute('data-nama');
                    item.style.display = text.includes(query) ? 'block' : 'none';
                });
            });

            // Pilih Semua
            selectAllCheckbox.addEventListener('change', function() {
                checkboxItems.forEach(item => {
                    if (item.style.display !== 'none') {
                        const checkbox = item.querySelector('input[type="checkbox"]');
                        checkbox.checked = this.checked;
                    }
                });
                updateSelectedCount();
            });

            // Hitung ulang saat ada checkbox diklik manual
            checkboxItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', updateSelectedCount);
            });

            updateSelectedCount();
        });
    </script>
@endsection
