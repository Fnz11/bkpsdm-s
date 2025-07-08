@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Tambah Usulan Pelatihan')
@section('page-title', 'Tambah Usulan Pelatihan')

@section('additional-css')
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.5rem + 2px);
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
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.usulan') }}"><i class="bi bi-lightbulb"></i> Usulan Pelatihan</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-plus-circle"></i> Tambah Usulan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold"><i class="bi bi-plus-circle me-2"></i>Form Tambah Usulan Pelatihan</div>
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.usulan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Kolom Kiri: Data Pegawai -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3"><i class="bi bi-person-badge me-1"></i> Data Pegawai</h5>

                        <!-- NIP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person-vcard me-1"></i> Pengusul</label>
                            <select name="nip_pengusul" id="nip" class="form-select select2" required>
                                <option value="">-- Pilih NIP --</option>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->nip }}">
                                        {{ $p->nip }} - {{ $p->refPegawai->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i> Nama</label>
                            <input type="text" id="nama" class="form-control" readonly>
                        </div>

                        <!-- Pangkat/Golongan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-award me-1"></i> Pangkat/Golongan</label>
                            <input type="text" id="pangkat_golongan" class="form-control" readonly>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-briefcase me-1"></i> Jabatan</label>
                            <input type="text" id="jabatan" class="form-control" readonly>
                        </div>

                        <!-- Unit Kerja -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i> Unit Kerja</label>
                            <input type="text" id="unitkerja" class="form-control" readonly>
                        </div>

                        <!-- Sub Unit Kerja -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building-gear me-1"></i> Sub Unit Kerja</label>
                            <input type="text" id="sub_unitkerja" class="form-control" readonly>
                        </div>

                        <!-- Nomor HP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-phone me-1"></i> No. HP</label>
                            <input type="text" id="no_hp" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Data Pelatihan -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3"><i class="bi bi-book me-1"></i> Data Pelatihan</h5>

                        <!-- Nama Pelatihan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-bookmark me-1"></i> Nama Pelatihan</label>
                            <select name="nama_pelatihan" id="nama_pelatihan" class="form-select select2" required>
                                <option value="">-- Pilih Pelaksanaan --</option>
                                @foreach ($namaPelatihan as $nama)
                                    <option value="{{ $nama->nama_pelatihan }}">
                                        {{ $nama->nama_pelatihan }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle me-1"></i> Apabila nama pelatihan tidak tersedia, silakan usul nama pelatihan terlebih dahulu dengan menekan tombol berikut:
                                <a href="{{ auth()->user()->hasRole('admin') ? route('dashboard.pelatihan.nomenklaturadmin.create') : route('dashboard.pelatihan.nomenklatur.create') }}" class="btn btn-success btn-sm mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Usul Nama Pelatihan
                                </a>
                                <p class="mb-0 mt-2"><small>Usulan nama pelatihan akan diverifikasi dan tunggu hingga disetujui.</small></p>
                            </div>
                        </div>

                        <!-- Jenis Pelatihan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-tags me-1"></i> Jenis Pelatihan</label>
                            <select name="jenispelatihan_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelatihan --</option>
                                @foreach ($jenisPelatihan as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->jenis_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Metode Pelatihan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-pc-display me-1"></i> Metode Pelatihan</label>
                            <select name="metodepelatihan_id" class="form-select" required>
                                <option value="">-- Pilih Metode Pelatihan --</option>
                                @foreach ($metodePelatihan as $metode)
                                    <option value="{{ $metode->id }}">{{ $metode->metode_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pelaksanaan Pelatihan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-check me-1"></i> Pelaksanaan Pelatihan</label>
                            <select name="pelaksanaanpelatihan_id" class="form-select" required>
                                <option value="">-- Pilih Pelaksanaan Pelatihan --</option>
                                @foreach ($pelaksanaanPelatihan as $pelaksanaan)
                                    <option value="{{ $pelaksanaan->id }}">
                                        {{ $pelaksanaan->pelaksanaan_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Penyelenggara -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i> Penyelenggara Pelatihan</label>
                            <input type="text" name="penyelenggara_pelatihan" class="form-control" placeholder="Contoh: Lembaga X / Instansi Y" required>
                        </div>

                        <!-- Tempat Pelatihan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i> Tempat Pelatihan</label>
                            <input type="text" name="tempat_pelatihan" class="form-control" placeholder="Contoh: Jakarta / Bandung / Online" required>
                        </div>

                        <!-- Tanggal Mulai & Selesai -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i> Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="bi bi-calendar2-week me-1"></i> Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Estimasi Biaya -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-cash-stack me-1"></i> Estimasi Biaya (Rp)</label>
                            <input type="number" name="estimasi_biaya" class="form-control" placeholder="Contoh: 5000000" min="0" required>
                        </div>

                        <!-- File Penawaran -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-file-earmark-pdf me-1"></i> File Penawaran (PDF)</label>
                            <input type="file" name="file_penawaran" class="form-control" accept=".pdf" required>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1"></i> Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan atau keterangan tambahan" required></textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                            <i class="bi bi-arrow-left-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Kirim Usulan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#nama_pelatihan').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Nama Pelatihan',
                allowClear: true
            });

            $('#nip').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Pengusul',
                allowClear: true
            });

            // Event saat NIP berubah
            $('select[name="nip_pengusul"]').on('change', function() {
                const nip = $(this).val();
                if (nip !== "") {
                    $.ajax({
                        url: '{{ route('get.pegawai.by.nip') }}',
                        type: 'GET',
                        data: {
                            nip: nip
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#nama').val(response.data.name ?? '');
                                $('#pangkat_golongan').val(response.data.pangkat_golongan ?? '');
                                $('#jabatan').val(response.data.jabatan ?? '');
                                $('#unitkerja').val(response.data.unitkerja ?? '');
                                $('#sub_unitkerja').val(response.data.sub_unitkerja ?? '');
                                $('#no_hp').val(response.data.no_hp ?? '');
                            } else {
                                alert('Data pegawai tidak ditemukan.');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data pegawai.');
                        }
                    });
                } else {
                    $('#nama').val('');
                    $('#pangkat_golongan').val('');
                    $('#jabatan').val('');
                    $('#unitkerja').val('');
                    $('#sub_unitkerja').val('');
                    $('#no_hp').val('');
                }
            });
        });
    </script>
@endsection