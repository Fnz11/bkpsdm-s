@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.dokumen') }}">Dokumen Pendaftaran</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.dokumen.update', $dokumen->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_dokumen" class="form-label fw-bold">Nama Dokumen</label>
                    <input type="text" id="nama_dokumen" class="form-control" value="{{ $dokumen->nama_dokumen }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">File Dokumen</label><br>
                    @php
                        $fileUrl = asset('storage/' . $dokumen->file_path);
                    @endphp
                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-success btn-md fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Lihat / Unduh Dokumen
                    </a>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                        value="{{ $dokumen->keterangan }}">
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="menunggu" {{ $dokumen->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ $dokumen->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $dokumen->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="text-end gap-2">
                    <a href="{{ route('dashboard.pelatihan.dokumen') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($pendaftarans->isNotEmpty())
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-light">
                <strong class="text-dark">Daftar Pendaftar Terkait</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Pendaftaran</th>
                                <th scope="col">Nama Pendaftar (NIP)</th>
                                <th scope="col">Nama Pelatihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftarans as $index => $pendaftaran)
                                <tr>
                                    <td class="text-center">{{ $pendaftarans->firstItem() + $index }}</td>
                                    <td class="text-center">{{ $pendaftaran->kode_pendaftaran }}</td>
                                    <td>
                                        {{ $pendaftaran->user->refPegawai->name ?? '-' }}
                                        <span class="text-muted">({{ $pendaftaran->user_nip }})</span>
                                    </td>
                                    <td>
                                        {{ $pendaftaran->tersedia->nama_pelatihan ?? ($pendaftaran->usulan->nama_pelatihan ?? '-') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 px-3 pb-3">
                    {{ $pendaftarans->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
@endsection
