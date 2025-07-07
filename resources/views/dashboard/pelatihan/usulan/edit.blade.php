@extends('layouts.Pelatihan.pelatihan-dashboard')

@section('title', 'Edit Usulan Pelatihan')
@section('page-title', 'Edit Usulan Pelatihan')

@section('additional-css')
    <style>
        .required-label::after {
            content: "*";
            color: red;
            position: absolute;
            top: 0;
            right: -12px;
            font-size: 1rem;
            line-height: 1;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.usulan') }}"><i class="bi bi-lightbulb"></i> Usulan
                Pelatihan</a></li>
        <li class="breadcrumb-item active"><i class="bi bi-pencil-square"></i> Edit Usulan</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning fw-bold text-white py-3">
            <i class="bi bi-pencil-square me-2"></i>Form Edit Usulan Pelatihan
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.usulan.update', $pelatihan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <!-- Kolom Kiri: Data Pegawai -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3"><i class="bi bi-person-badge me-1"></i> Data Pegawai</h5>

                        <!-- NIP (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person-vcard me-1"></i> NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ $pelatihan->nip_pengusul }}"
                                readonly>
                        </div>

                        <!-- Kolom readonly lainnya -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i> Nama</label>
                            <input type="text" id="nama" class="form-control"
                                value="{{ $pelatihan->user->refPegawai->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-award me-1"></i> Pangkat/Golongan</label>
                            <input type="text" id="pangkat_golongan" class="form-control"
                                value="{{ $pelatihan->user->latestUserPivot->golongan->pangkat_golongan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-briefcase me-1"></i> Jabatan</label>
                            <input type="text" id="jabatan" class="form-control"
                                value="{{ $pelatihan->user->latestUserPivot->jabatan->jabatan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i> Unit Kerja</label>
                            <input type="text" id="unitkerja" class="form-control"
                                value="{{ $pelatihan->user->latestUserPivot->unitKerja->unitkerja->unitkerja }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building-gear me-1"></i> Sub Unit
                                Kerja</label>
                            <input type="text" id="sub_unitkerja" class="form-control"
                                value="{{ $pelatihan->user->latestUserPivot->unitKerja->sub_unitkerja }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-phone me-1"></i> No. HP</label>
                            <input type="text" id="no_hp" class="form-control"
                                value="{{ $pelatihan->user->refPegawai->no_hp }}" readonly>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Data Pelatihan -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3"><i class="bi bi-book me-1"></i> Data Pelatihan</h5>

                        <!-- Nama Pelatihan (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-bookmark me-1"></i> Nama Pelatihan</label>
                            <input type="text" class="form-control" value="{{ $pelatihan->nama_pelatihan }}" readonly>
                        </div>

                        <!-- Pelaksanaan Pelatihan (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-check me-1"></i> Pelaksanaan
                                Pelatihan</label>
                            <input type="text" class="form-control"
                                value="{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan }}" readonly>
                        </div>

                        <!-- Metode Pelatihan (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-pc-display me-1"></i> Metode
                                Pelatihan</label>
                            <input type="text" class="form-control"
                                value="{{ $pelatihan->metodepelatihan->metode_pelatihan }}" readonly>
                        </div>

                        <!-- Jenis Pelatihan (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-tags me-1"></i> Jenis Pelatihan</label>
                            <input type="text" class="form-control"
                                value="{{ $pelatihan->jenispelatihan->jenis_pelatihan }}" readonly>
                        </div>

                        <!-- Penyelenggara (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i> Penyelenggara
                                Pelatihan</label>
                            <input type="text" class="form-control" value="{{ $pelatihan->penyelenggara_pelatihan }}"
                                readonly>
                        </div>

                        <!-- Tempat (readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i> Tempat
                                Pelatihan</label>
                            <input type="text" class="form-control" value="{{ $pelatihan->tempat_pelatihan }}"
                                readonly>
                        </div>

                        <!-- Tanggal -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i> Tanggal
                                    Mulai</label>
                                <input type="date" class="form-control" value="{{ $pelatihan->tanggal_mulai }}"
                                    readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="bi bi-calendar2-week me-1"></i> Tanggal
                                    Selesai</label>
                                <input type="date" class="form-control" value="{{ $pelatihan->tanggal_selesai }}"
                                    readonly>
                            </div>
                        </div>

                        <!-- Estimasi Biaya -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-cash-stack me-1"></i> Estimasi Biaya
                                (Rp)</label>
                            <input type="number" class="form-control" value="{{ $pelatihan->estimasi_biaya }}"
                                readonly>
                        </div>

                        <!-- Realisasi Biaya -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold position-relative required-label"><i
                                    class="bi bi-cash-coin me-1"></i> Realisasi Biaya (Rp)</label>
                            <input type="number" step="1000" name="realisasi_biaya" class="form-control"
                                value="{{ $pelatihan->realisasi_biaya }}" required>
                        </div>

                        <!-- File Penawaran -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-file-earmark-pdf me-1"></i> File
                                Penawaran</label><br>
                            @if ($pelatihan->file_penawaran)
                                <a href="{{ asset('storage/' . $pelatihan->file_penawaran) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Lihat File
                                </a>
                            @else
                                <span class="text-muted"><i class="bi bi-file-earmark-excel me-1"></i> Tidak ada
                                    file</span>
                            @endif
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1"></i>
                                Keterangan</label>
                            <textarea class="form-control" rows="3" readonly>{{ $pelatihan->keterangan }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1"></i>
                                Status Verifikasi</label>
                            <select class="form-select" name="status_verifikasi" required>
                                <option value="tersimpan"
                                    {{ $pelatihan->pendaftaran?->status_verifikasi == 'tersimpan' ? 'selected' : '' }}
                                    disabled>
                                    Tersimpan</option>
                                <option value="tercetak"
                                    {{ $pelatihan->pendaftaran?->status_verifikasi == 'tercetak' ? 'selected' : '' }}
                                    disabled>
                                    Tercetak</option>
                                <option value="terkirim"
                                    {{ $pelatihan->pendaftaran?->status_verifikasi == 'terkirim' ? 'selected' : '' }}
                                    disabled>
                                    Terkirim</option>
                                <option value="diterima"
                                    {{ $pelatihan->pendaftaran?->status_verifikasi == 'diterima' ? 'selected' : '' }}>
                                    Diterima</option>
                                <option value="ditolak"
                                    {{ $pelatihan->pendaftaran?->status_verifikasi == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                            <i class="bi bi-arrow-left-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "Cari...",
                allowClear: true,
                width: '100%'
            });

            $('select[name="nip"]').on('change', function() {
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
                                $('#pangkat_golongan').val(response.data.pangkat_golongan ??
                                    '');
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
                    $('#nama, #pangkat_golongan, #jabatan, #unitkerja, #sub_unitkerja, #no_hp').val('');
                }
            });
        });
    </script>
@endsection
